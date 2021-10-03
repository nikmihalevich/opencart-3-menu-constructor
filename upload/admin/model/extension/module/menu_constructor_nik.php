<?php
class ModelExtensionModuleMenuConstructorNik extends Model {
	public function install() {
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item` (
		  `menu_item_id` INT(11) NOT NULL AUTO_INCREMENT,
		  `sort_order` INT(11) NOT NULL,
		  `status` TINYINT(1) NOT NULL DEFAULT 1,
		  PRIMARY KEY (`menu_item_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
        $this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_description` (
		  `id` INT(11) NOT NULL AUTO_INCREMENT,
		  `menu_item_id` INT(11) NOT NULL,
		  `language_id` INT(11) NOT NULL,
		  `name` VARCHAR(64) NOT NULL,
          `link` VARCHAR(255) NOT NULL,
		  PRIMARY KEY (`id`, `language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_block` (
		  `menu_item_id` INT(11) NOT NULL AUTO_INCREMENT,
		  `sort_order` INT(11) NOT NULL,
		  `status` TINYINT(1) NOT NULL DEFAULT 1,
		  PRIMARY KEY (`menu_item_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
        $this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_description` (
		  `id` INT(11) NOT NULL AUTO_INCREMENT,
		  `menu_item_id` INT(11) NOT NULL,
		  `language_id` INT(11) NOT NULL,
		  `name` VARCHAR(64) NOT NULL,
          `link` VARCHAR(255) NOT NULL,
		  PRIMARY KEY (`id`, `language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_description`");
	}

    public function addMenuItem($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item SET `sort_order` = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

        $menu_item_id = $this->db->getLastId();

        foreach ($data['menu_constructor_nik_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', `name` = '" . $this->db->escape($value['name']) . "', `link` = '" . $this->db->escape($value['link']) . "'");
        }

        $this->cache->delete('menu_item');

        return $menu_item_id;
    }

    public function editMenuItem($menu_item_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "menu_item SET `sort_order` = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE menu_item_id = '" . $menu_item_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

        foreach ($data['menu_constructor_nik_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', `name` = '" . $this->db->escape($value['name']) . "', `link` = '" . $this->db->escape($value['link']) . "'");
        }

        $this->cache->delete('menu_item');
    }

    public function deleteMenuItem($menu_item_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "menu_item` WHERE menu_item_id = '" . (int)$menu_item_id . "'");
        $this->db->query("DELETE FROM `" . DB_PREFIX . "menu_item_description` WHERE menu_item_id = '" . (int)$menu_item_id . "'");

        $this->cache->delete('menu_item');
    }

    public function getMenuItem($menu_item_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item WHERE menu_item_id = '" . (int)$menu_item_id . "'");

        return $query->row;
    }

    public function getMenuItemDescription($menu_item_id) {
        $menu_item_description_data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

        foreach ($query->rows as $result) {
            $menu_item_description_data[$result['language_id']] = array(
                'name' => $result['name'],
                'link' => $result['link']
            );
        }

        return $menu_item_description_data;
    }

    public function getMenuItems($data = array()) {
        $sql = "SELECT * FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mid.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        $sort_data = array(
            'mid.name',
            'mi.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY mid.name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }
}
