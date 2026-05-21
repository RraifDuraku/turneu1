<?php
/**
 * User Class for Authentication
 */

class User {
    private $db;
    private $table = 'users';
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Register new user
     */
    public function register($username, $email, $password, $fullname, $role = 'editor') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = "INSERT INTO {$this->table} (username, email, password, fullname, role) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssss', $username, $email, $hashedPassword, $fullname, $role);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'User registered successfully'];
        }
        return ['success' => false, 'message' => 'Registration failed'];
    }
    
    /**
     * Authenticate user
     */
    public function login($username, $password) {
        $sql = "SELECT id, username, password, email, role, status FROM {$this->table} WHERE username = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if ($user['status'] === 'inactive') {
                return ['success' => false, 'message' => 'Account is inactive'];
            }
            
            if (password_verify($password, $user['password'])) {
                unset($user['password']);
                return ['success' => true, 'user' => $user];
            }
        }
        
        return ['success' => false, 'message' => 'Invalid username or password'];
    }
    
    /**
     * Get user by ID
     */
    public function getUserById($id) {
        $sql = "SELECT id, username, email, fullname, role, status, created_at FROM {$this->table} WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    /**
     * Get all users
     */
    public function getAllUsers() {
        $sql = "SELECT id, username, email, fullname, role, status, created_at FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Update user
     */
    public function updateUser($id, $email, $fullname, $status) {
        $sql = "UPDATE {$this->table} SET email = ?, fullname = ?, status = ? WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssi', $email, $fullname, $status, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Change password
     */
    public function changePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        
        $sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('si', $hashedPassword, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Delete user
     */
    public function deleteUser($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }
}
?>
