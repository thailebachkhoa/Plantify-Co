<?php
class Content
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllSiteContent()
    {
        $this->db->query("SELECT * FROM site_content ORDER BY content_group, id");

        return $this->db->resultSet();
    }

    public function getAllPages()
    {
        $this->db->query("SELECT * FROM pages ORDER BY slug");
        return $this->db->resultSet();
    }

    public function updateSiteContent($key, $value)
    {
        $this->db->query("UPDATE site_content SET content_value = :val WHERE content_key = :key");
        $this->db->bind(':val', $value);
        $this->db->bind(':key', $key);
        return $this->db->execute();
    }
    public function updateMultipleSiteContent(array $data)
    {
        foreach ($data as $key => $value) {
            $this->updateSiteContent($key, $value);
        }
        return true;
    }

    public function getSiteContentByGroups(array $groups)
    {

        $placeholders = implode(',', array_fill(0, count($groups), '?'));

        $sql = "SELECT * FROM site_content 
                WHERE content_group IN ($placeholders) 
                ORDER BY FIELD(content_group, 'Trang cửa hàng', 'Trang chi tiết SP', 'Trang giỏ hàng'), id ASC";

        $this->db->query($sql);

        foreach ($groups as $index => $group) {
            $this->db->bind($index + 1, $group);
        }

        return $this->db->resultSet();
    }
}