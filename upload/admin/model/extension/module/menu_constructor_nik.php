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
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_block` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `menu_item_id` INT(11) NOT NULL,
            `grid_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_block_data` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `block_id` INT(11) NOT NULL,
            `col_id` INT(11) NOT NULL,
            `block_grid_width` VARCHAR(20) DEFAULT NULL,
            `text` TEXT DEFAULT NULL,
            `text_ordinal` INT(11) DEFAULT NULL,
            `products_ordinal` INT(11) DEFAULT NULL,
            `menu_items_ordinal` INT(11) DEFAULT NULL,
            `sort_ordinal` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_to_menu_item_block` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `product_id` INT(11) NOT NULL,
            `block_data_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_to_menu_item_block` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `menu_item_id` INT(11) NOT NULL,
            `block_data_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
	}

	public function uninstall() {
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_description`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_block`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_block_data`");
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

    public function addBlock($menu_item_id, $grid_id) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_block SET `menu_item_id` = '" . (int)$menu_item_id . "', `grid_id` = '" . (int)$grid_id . "'");

        $block_id = $this->db->getLastId();

        $this->cache->delete('menu_item_block');

        return $block_id;
    }

    public function deleteBlock($block_id) {
        $blocks_data = $this->getBlockData($block_id);
        foreach ($blocks_data as $block_data) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_menu_item_block WHERE block_data_id = '" . (int)$block_data['id'] . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_to_menu_item_block WHERE block_data_id = '" . (int)$block_data['id'] . "'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_block WHERE `id` = '" . (int)$block_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_block_data WHERE `block_id` = '" . (int)$block_id . "'");

        $this->cache->delete('menu_item_block');
        $this->cache->delete('menu_item_block_data');
    }

    public function getBlock($menu_item_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block WHERE `menu_item_id` = '" . (int)$menu_item_id . "'");

        return $query->row;
    }

    public function getBlockById($block_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block WHERE `id` = '" . (int)$block_id . "'");

        return $query->row;
    }

    public function addBlockData($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_block_data SET `block_id` = '" . (int)$data['block_id'] . "', `col_id` = '" . (int)$data['col_id'] . "', `block_grid_width` = '" . $this->db->escape($data['block_grid_width']) . "', `text` = '" . $this->db->escape($data['block_data']['text']) . "', `text_ordinal` = '" . (int)$data['block_data']['text_ordinal'] . "', `products_ordinal` = '" . (int)$data['block_data']['products_ordinal'] . "', `menu_items_ordinal` = '" . (int)$data['block_data']['menu_items_ordinal'] . "'");

        $block_data_id = $this->db->getLastId();

        if(isset($data['added_products_id'])) {
            foreach ($data['added_products_id'] as $added_product_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_menu_item_block SET product_id = '" . (int)$added_product_id . "', block_data_id = '" . (int)$block_data_id . "'");
            }
        }

        if(isset($data['added_menu_items_id'])) {
            foreach ($data['added_menu_items_id'] as $added_menu_item_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_to_menu_item_block SET `menu_item_id` = '" . (int)$added_menu_item_id . "', block_data_id = '" . (int)$block_data_id . "'");
            }
        }

        $this->cache->delete('menu_item_block_data');
        $this->cache->delete('product_to_menu_item_block');

        return $block_data_id;
    }

    public function editBlockData($data) {
        $this->db->query("UPDATE " . DB_PREFIX . "menu_item_block_data SET `text` = '" . $this->db->escape($data['block_data']['text']) . "', `text_ordinal` = '" . (int)$data['block_data']['text_ordinal'] . "', `products_ordinal` = '" . (int)$data['block_data']['products_ordinal'] . "', `menu_items_ordinal` = '" . (int)$data['block_data']['menu_items_ordinal'] . "' WHERE `id` = '" . (int)$data['block_data_id'] . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_menu_item_block WHERE `block_data_id` = '" . (int)$data['block_data_id'] . "'");
        if(isset($data['added_products_id'])) {
            foreach ($data['added_products_id'] as $added_product_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_menu_item_block SET product_id = '" . (int)$added_product_id . "', block_data_id = '" . (int)$data['block_data_id'] . "'");
            }
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_to_menu_item_block WHERE `block_data_id` = '" . (int)$data['block_data_id'] . "'");
        if(isset($data['added_menu_items_id'])) {
            foreach ($data['added_menu_items_id'] as $added_menu_item_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_to_menu_item_block SET `menu_item_id` = '" . (int)$added_menu_item_id . "', block_data_id = '" . (int)$data['block_data_id'] . "'");
            }
        }

        $this->cache->delete('menu_item_block_data');
        $this->cache->delete('product_to_menu_item_block');
    }

    public function deleteBlockData($block_data_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_menu_item_block WHERE block_data_id = '" . (int)$block_data_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_to_menu_item_block WHERE block_data_id = '" . (int)$block_data_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_block_data WHERE `id` = '" . (int)$block_data_id . "'");

        $this->cache->delete('menu_item_block_data');
    }


    public function getBlockData($block_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block_data WHERE `block_id` = '" . (int)$block_id . "'");

        $block_data_info = $query->rows;

        foreach ($block_data_info as $k => $block_data) {
            $query2 = $this->db->query("SELECT `product_id` FROM " . DB_PREFIX . "product_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data['id'] . "'");
            $block_data_info[$k]['products'] = $query2->rows;
        }

        foreach ($block_data_info as $k => $block_data) {
            $query3 = $this->db->query("SELECT `menu_item_id` FROM " . DB_PREFIX . "menu_item_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data['id'] . "'");
            $block_data_info[$k]['menu_items'] = $query3->rows;
        }

        return $block_data_info;
    }

    public function getBlockDataByBlockDataId($block_data_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block_data WHERE `id` = '" . (int)$block_data_id . "'");

        $block_data_info = $query->row;

        $query2 = $this->db->query("SELECT `product_id` FROM " . DB_PREFIX . "product_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data_id . "'");
        $block_data_info['products'] = $query2->rows;

        $query3 = $this->db->query("SELECT `menu_item_id` FROM " . DB_PREFIX . "menu_item_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data_id . "'");
        $block_data_info['menu_items'] = $query3->rows;

        return $block_data_info;
    }

    public function getTotalProductsByCategoryId($category_id) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "'");

        return $query->row['total'];
    }
}
