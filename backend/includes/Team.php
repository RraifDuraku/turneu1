<?php
/**
 * Team Management Class
 */

class Team {
    private $db;
    private $table = 'teams';
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Create team
     */
    public function create($name, $description, $logo, $coach_name, $status = 'active') {
        $sql = "INSERT INTO {$this->table} (name, description, logo, coach_name, status) VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssss', $name, $description, $logo, $coach_name, $status);
        
        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false];
    }
    
    /**
     * Get all teams
     */
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get team by ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    /**
     * Update team
     */
    public function update($id, $name, $description, $logo, $coach_name, $status) {
        $sql = "UPDATE {$this->table} SET name = ?, description = ?, logo = ?, coach_name = ?, status = ? WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssssi', $name, $description, $logo, $coach_name, $status, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Delete team
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }
}
?>
