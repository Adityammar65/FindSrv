<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id_chat';
    protected $useAutoIncrement = true;
    
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    // Allowed fields for insert/update
    protected $allowedFields = [
        'id_pengirim',
        'id_penerima',
        'pesan',
        'waktu_kirim'
    ];
    
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'waktu_kirim';
    protected $updatedField = '';
    protected $deletedField = '';
    
    // Validation rules
    protected $validationRules = [
        'id_pengirim' => 'required|integer|is_not_unique[users.id_user]',
        'id_penerima' => 'required|integer|is_not_unique[users.id_user]|differs[id_pengirim]',
        'pesan' => 'required|string|min_length[1]|max_length[1000]',
    ];
    
    protected $validationMessages = [
        'id_pengirim' => [
            'required' => 'Pengirim harus diisi',
            'integer' => 'ID pengirim tidak valid',
            'is_not_unique' => 'Pengirim tidak ditemukan'
        ],
        'id_penerima' => [
            'required' => 'Penerima harus diisi',
            'integer' => 'ID penerima tidak valid',
            'is_not_unique' => 'Penerima tidak ditemukan',
            'differs' => 'Tidak dapat mengirim pesan ke diri sendiri'
        ],
        'pesan' => [
            'required' => 'Pesan tidak boleh kosong',
            'min_length' => 'Pesan terlalu pendek',
            'max_length' => 'Pesan maksimal 1000 karakter'
        ]
    ];
    
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
    
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['setTimestamp'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
    
    /**
     * Set timestamp before insert
     */
    protected function setTimestamp(array $data): array
    {
        if (!isset($data['data']['waktu_kirim'])) {
            $data['data']['waktu_kirim'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
    
    /**
     * Get conversation between two users
     * 
     * @param int $userId1 First user ID
     * @param int $userId2 Second user ID
     * @param int $limit Number of messages to fetch
     * @return array
     */
    public function getConversation(int $userId1, int $userId2, int $limit = 50): array
    {
        return $this->select('chat.*, 
                u1.username as pengirim_username,
                u2.username as penerima_username')
            ->join('users u1', 'u1.id_user = chat.id_pengirim', 'left')
            ->join('users u2', 'u2.id_user = chat.id_penerima', 'left')
            ->groupStart()
                ->where('chat.id_pengirim', $userId1)
                ->where('chat.id_penerima', $userId2)
            ->groupEnd()
            ->orGroupStart()
                ->where('chat.id_pengirim', $userId2)
                ->where('chat.id_penerima', $userId1)
            ->groupEnd()
            ->orderBy('chat.waktu_kirim', 'ASC')
            ->limit($limit)
            ->findAll();
    }
    
    /**
     * Get all chat contacts for a user
     * Returns list of users who have chatted with the given user
     * 
     * @param int $userId User ID
     * @return array
     */
    public function getChatContacts(int $userId): array
    {
        $db = \Config\Database::connect();
        
        $sql = "
            SELECT 
                contact_id,
                contact_username,
                contact_email,
                last_message,
                last_message_time
            FROM (
                SELECT DISTINCT
                    CASE 
                        WHEN chat.id_pengirim = ? THEN chat.id_penerima
                        ELSE chat.id_pengirim
                    END as contact_id,
                    users.username as contact_username,
                    users.email as contact_email,
                    chat.pesan as last_message,
                    chat.waktu_kirim as last_message_time,
                    ROW_NUMBER() OVER (
                        PARTITION BY CASE 
                            WHEN chat.id_pengirim = ? THEN chat.id_penerima
                            ELSE chat.id_pengirim
                        END 
                        ORDER BY chat.waktu_kirim DESC
                    ) as rn
                FROM chat
                JOIN users ON users.id_user = CASE 
                    WHEN chat.id_pengirim = ? THEN chat.id_penerima
                    ELSE chat.id_pengirim
                END
                WHERE chat.id_pengirim = ? OR chat.id_penerima = ?
            ) as subquery
            WHERE rn = 1
            ORDER BY last_message_time DESC
        ";
        
        $query = $db->query($sql, [$userId, $userId, $userId, $userId, $userId]);
        return $query->getResultArray();
    }
    
    /**
     * Get unread message count for a user from a specific sender
     * Note: This is a placeholder. Implement proper read tracking if needed.
     * 
     * @param int $receiverId Receiver user ID
     * @param int $senderId Sender user ID
     * @return int
     */
    public function getUnreadCount(int $receiverId, int $senderId): int
    {
        return $this->where('id_penerima', $receiverId)
            ->where('id_pengirim', $senderId)
            ->countAllResults();
    }
    
    /**
     * Delete conversation between two users
     * 
     * @param int $userId1 First user ID
     * @param int $userId2 Second user ID
     * @return bool
     */
    public function deleteConversation(int $userId1, int $userId2): bool
    {
        return $this->groupStart()
                ->where('id_pengirim', $userId1)
                ->where('id_penerima', $userId2)
            ->groupEnd()
            ->orGroupStart()
                ->where('id_pengirim', $userId2)
                ->where('id_penerima', $userId1)
            ->groupEnd()
            ->delete();
    }
    
    /**
     * Search messages by keyword for a specific user
     * 
     * @param int $userId User ID
     * @param string $keyword Search keyword
     * @param int $limit Result limit
     * @return array
     */
    public function searchMessages(int $userId, string $keyword, int $limit = 20): array
    {
        return $this->select('chat.*, 
                u1.username as pengirim_username,
                u2.username as penerima_username')
            ->join('users u1', 'u1.id_user = chat.id_pengirim', 'left')
            ->join('users u2', 'u2.id_user = chat.id_penerima', 'left')
            ->groupStart()
                ->where('chat.id_pengirim', $userId)
                ->orWhere('chat.id_penerima', $userId)
            ->groupEnd()
            ->like('chat.pesan', $keyword)
            ->orderBy('chat.waktu_kirim', 'DESC')
            ->limit($limit)
            ->findAll();
    }
    
    /**
     * Get latest message between two users
     * 
     * @param int $userId1 First user ID
     * @param int $userId2 Second user ID
     * @return array|null
     */
    public function getLatestMessage(int $userId1, int $userId2): ?array
    {
        $result = $this->select('chat.*, 
                u1.username as pengirim_username,
                u2.username as penerima_username')
            ->join('users u1', 'u1.id_user = chat.id_pengirim', 'left')
            ->join('users u2', 'u2.id_user = chat.id_penerima', 'left')
            ->groupStart()
                ->where('chat.id_pengirim', $userId1)
                ->where('chat.id_penerima', $userId2)
            ->groupEnd()
            ->orGroupStart()
                ->where('chat.id_pengirim', $userId2)
                ->where('chat.id_penerima', $userId1)
            ->groupEnd()
            ->orderBy('chat.waktu_kirim', 'DESC')
            ->first();
        
        return $result ?: null;
    }
    
    /**
     * Get chat statistics for a user
     * 
     * @param int $userId User ID
     * @return array
     */
    public function getChatStats(int $userId): array
    {
        $totalSent = $this->where('id_pengirim', $userId)->countAllResults(false);
        $totalReceived = $this->where('id_penerima', $userId)->countAllResults(false);
        $contacts = $this->getChatContacts($userId);
        
        return [
            'total_sent' => $totalSent,
            'total_received' => $totalReceived,
            'total_contacts' => count($contacts),
            'total_messages' => $totalSent + $totalReceived
        ];
    }
    
    /**
     * Delete old messages (cleanup utility)
     * 
     * @param int $days Delete messages older than X days
     * @return int Number of deleted records
     */
    public function deleteOldMessages(int $days = 90): int
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        
        $this->where('waktu_kirim <', $date)->delete();
        
        return $this->db->affectedRows();
    }
}