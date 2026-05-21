<?php
/**
 * Page/Content Management Class
 */

class Page {
    private $db;
    private $table = 'pages';
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Create new page
     */
    public function create($title, $slug, $content, $description, $featured_image, $status, $author_id, $seo_title = '', $seo_description = '', $seo_keywords = '') {
        $sql = "INSERT INTO {$this->table} (title, slug, content, description, featured_image, status, author_id, seo_title, seo_description, seo_keywords) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ssssssisss', $title, $slug, $content, $description, $featured_image, $status, $author_id, $seo_title, $seo_description, $seo_keywords);
        
        if ($stmt->execute()) {
            return ['success' => true, 'id' => $this->db->lastInsertId()];
        }
        return ['success' => false, 'message' => 'Failed to create page'];
    }
    
    /**
     * Get page by ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    /**
     * Get page by slug
     */
    public function getBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ? AND status = 'published'";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    /**
     * Get all pages with pagination
     */
    public function getAll($limit = 10, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Update page
     */
    public function update($id, $title, $slug, $content, $description, $featured_image, $status, $seo_title, $seo_description, $seo_keywords) {
        $sql = "UPDATE {$this->table} SET title = ?, slug = ?, content = ?, description = ?, featured_image = ?, status = ?, seo_title = ?, seo_description = ?, seo_keywords = ? WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('sssssssssi', $title, $slug, $content, $description, $featured_image, $status, $seo_title, $seo_description, $seo_keywords, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Delete page
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        
        return $stmt->execute();
    }
    
    /**
     * Get published pages
     */
    public function getPublished($limit = 10, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} WHERE status = 'published' ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
