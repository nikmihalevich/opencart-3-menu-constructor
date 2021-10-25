<?php
class ModelExtensionModuleMenuConstructorNik extends Model {
	public function install() {
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item` (
		  `menu_item_id` INT(11) NOT NULL AUTO_INCREMENT,
		  `parent_id` INT(11) NOT NULL,
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
          `bottom_link_name` VARCHAR(64) NOT NULL,
          `bottom_link` VARCHAR(255) NOT NULL,
		  PRIMARY KEY (`id`, `language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
        $this->db->query("
		CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_path` (
		  `menu_item_id` INT(11) NOT NULL,
		  `path_id` INT(11) NOT NULL,
		  `level` INT(11) NOT NULL,
		  PRIMARY KEY (`menu_item_id`, `path_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_block` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `menu_item_id` INT(11) NOT NULL,
            `grid_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_block_col` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `col_id` INT(11) NOT NULL,
            `block_id` INT(11) NOT NULL,
            `col_width` VARCHAR(64) NOT NULL,
            PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "menu_item_block_data` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `block_id` INT(11) NOT NULL,
            `block_col_id` INT(11) NOT NULL,
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
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_path`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_block`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_block_col`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_block_data`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_to_menu_item_block`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "menu_item_to_menu_item_block`");
	}

    public function addMenuItem($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item SET `parent_id` = '" . (int)$data['parent_id'] . "', `sort_order` = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "'");

        $menu_item_id = $this->db->getLastId();

        foreach ($data['menu_constructor_nik_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', `name` = '" . $this->db->escape($value['name']) . "', `link` = '" . $this->db->escape($value['link']) . "', `bottom_link_name` = '" . $this->db->escape($value['bottom_link_name']) . "', `bottom_link` = '" . $this->db->escape($value['bottom_link']) . "'");
        }

        // MySQL Hierarchical Data Closure Table Pattern
        $level = 0;

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "menu_item_path` WHERE menu_item_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

        foreach ($query->rows as $result) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "menu_item_path` SET `menu_item_id` = '" . (int)$menu_item_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

            $level++;
        }

        $this->db->query("INSERT INTO `" . DB_PREFIX . "menu_item_path` SET `menu_item_id` = '" . (int)$menu_item_id . "', `path_id` = '" . (int)$menu_item_id . "', `level` = '" . (int)$level . "'");

        $this->cache->delete('menu_item');

        return $menu_item_id;
    }

    public function editMenuItem($menu_item_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "menu_item SET `parent_id` = '" . (int)$data['parent_id'] . "', `sort_order` = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "' WHERE menu_item_id = '" . $menu_item_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "menu_item_description WHERE menu_item_id = '" . (int)$menu_item_id . "'");

        foreach ($data['menu_constructor_nik_description'] as $language_id => $value) {
            if (!isset($value['bottom_link_name'])) {
                $value['bottom_link_name'] = '';
                $value['bottom_link'] = '';
            }
            $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_description SET menu_item_id = '" . (int)$menu_item_id . "', language_id = '" . (int)$language_id . "', `name` = '" . $this->db->escape($value['name']) . "', `link` = '" . $this->db->escape($value['link']) . "', `bottom_link_name` = '" . $this->db->escape($value['bottom_link_name']) . "', `bottom_link` = '" . $this->db->escape($value['bottom_link']) . "'");
        }

        // MySQL Hierarchical Data Closure Table Pattern
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "menu_item_path` WHERE path_id = '" . (int)$menu_item_id . "' ORDER BY level ASC");

        if ($query->rows) {
            foreach ($query->rows as $menu_item_path) {
                // Delete the path below the current one
                $this->db->query("DELETE FROM `" . DB_PREFIX . "menu_item_path` WHERE menu_item_id = '" . (int)$menu_item_path['menu_item_id'] . "' AND level < '" . (int)$menu_item_path['level'] . "'");

                $path = array();

                // Get the nodes new parents
                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "menu_item_path` WHERE menu_item_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

                foreach ($query->rows as $result) {
                    $path[] = $result['path_id'];
                }

                // Get whats left of the nodes current path
                $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "menu_item_path` WHERE menu_item_id = '" . (int)$menu_item_path['menu_item_id'] . "' ORDER BY level ASC");

                foreach ($query->rows as $result) {
                    $path[] = $result['path_id'];
                }

                // Combine the paths with a new level
                $level = 0;

                foreach ($path as $path_id) {
                    $this->db->query("REPLACE INTO `" . DB_PREFIX . "menu_item_path` SET menu_item_id = '" . (int)$menu_item_path['menu_item_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");

                    $level++;
                }
            }
        } else {
            // Delete the path below the current one
            $this->db->query("DELETE FROM `" . DB_PREFIX . "menu_item_path` WHERE menu_item_id = '" . (int)$menu_item_id . "'");

            // Fix for records with no paths
            $level = 0;

            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "menu_item_path` WHERE menu_item_id = '" . (int)$data['parent_id'] . "' ORDER BY level ASC");

            foreach ($query->rows as $result) {
                $this->db->query("INSERT INTO `" . DB_PREFIX . "menu_item_path` SET menu_item_id = '" . (int)$menu_item_id . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");

                $level++;
            }

            $this->db->query("REPLACE INTO `" . DB_PREFIX . "menu_item_path` SET menu_item_id = '" . (int)$menu_item_id . "', `path_id` = '" . (int)$menu_item_id . "', level = '" . (int)$level . "'");
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
                'name'             => $result['name'],
                'link'             => $result['link'],
                'bottom_link_name' => $result['bottom_link_name'],
                'bottom_link'      => $result['bottom_link'],
            );
        }

        return $menu_item_description_data;
    }

    public function getMenuItemName($menu_item_id) {
        $query = $this->db->query("SELECT `menu_item_id`, `name` FROM " . DB_PREFIX . "menu_item_description WHERE `menu_item_id` = '" . (int)$menu_item_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') ."'");

        return $query->row;
    }

    public function getMenuItems($data = array()) {
        $sql = "SELECT mip.menu_item_id AS menu_item_id, GROUP_CONCAT(mid1.name ORDER BY mip.level SEPARATOR '&nbsp;&nbsp;&gt;&nbsp;&nbsp;') AS name, mi1.parent_id, mi1.sort_order FROM " . DB_PREFIX . "menu_item_path mip LEFT JOIN " . DB_PREFIX . "menu_item mi1 ON (mip.menu_item_id = mi1.menu_item_id) LEFT JOIN " . DB_PREFIX . "menu_item mi2 ON (mip.path_id = mi2.menu_item_id) LEFT JOIN " . DB_PREFIX . "menu_item_description mid1 ON (mip.path_id = mid1.menu_item_id) LEFT JOIN " . DB_PREFIX . "menu_item_description mid2 ON (mip.menu_item_id = mid2.menu_item_id) WHERE mid1.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mid2.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {
            $sql .= " AND mid2.`name` LIKE '" . $this->db->escape($data['filter_name']) . "%'";
        }

        $sql .= " GROUP BY mip.menu_item_id";

        $sort_data = array(
            'name',
            'sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getMenuItemsParents() {
        $query = $this->db->query("SELECT mi.menu_item_id, mid.`name` FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mi.parent_id = '0' ORDER BY mid.name ASC");

        return $query->rows;
    }

    public function getMenuItemsByParentId($parent_id) {
        $query = $this->db->query("SELECT mi.menu_item_id, mid.`name` FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mi.parent_id = '" . (int)$parent_id . "' ORDER BY mid.name ASC");

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

    public function addBlockCol($col_id, $block_id, $col_width) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_block_col SET `col_id` = '" . (int)$col_id . "', `block_id` = '" . (int)$block_id . "', `col_width` = '" . $this->db->escape($col_width) . "'");

        $block_col_id = $this->db->getLastId();

        $this->cache->delete('menu_item_block_col');

        return $block_col_id;
    }

    public function getBlockCols($block_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block_col WHERE `block_id` = '" . (int)$block_id . "'");

        return $query->rows;
    }

    public function addBlockData($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "menu_item_block_data SET `block_id` = '" . (int)$data['block_id'] . "', `block_col_id` = '" . (int)$data['block_col_id'] . "', `text` = '" . $this->db->escape($data['block_data']['text']) . "', `text_ordinal` = '" . (int)$data['block_data']['text_ordinal'] . "', `products_ordinal` = '" . (int)$data['block_data']['products_ordinal'] . "', `menu_items_ordinal` = '" . (int)$data['block_data']['menu_items_ordinal'] . "'");

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


    public function getBlockData($block_col_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block_data WHERE `block_col_id` = '" . (int)$block_col_id . "'");

        $block_data_info = $query->rows;

        foreach ($block_data_info as $k => $block_data) {
            $query2 = $this->db->query("SELECT `product_id` FROM " . DB_PREFIX . "product_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data['id'] . "' ORDER BY `id`");
            $block_data_info[$k]['products'] = $query2->rows;
        }

        foreach ($block_data_info as $k => $block_data) {
            $query3 = $this->db->query("SELECT `menu_item_id` FROM " . DB_PREFIX . "menu_item_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data['id'] . "' ORDER BY `id`");
            $block_data_info[$k]['menu_items'] = $query3->rows;
        }

        return $block_data_info;
    }

    public function getBlockDataByBlockDataId($block_data_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block_data WHERE `id` = '" . (int)$block_data_id . "'");

        $block_data_info = $query->row;

        $query2 = $this->db->query("SELECT `product_id` FROM " . DB_PREFIX . "product_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data_id . "' ORDER BY `id`");
        $block_data_info['products'] = $query2->rows;

        $query3 = $this->db->query("SELECT `menu_item_id` FROM " . DB_PREFIX . "menu_item_to_menu_item_block WHERE `block_data_id` = '" . (int)$block_data_id . "' ORDER BY `id`");
        $block_data_info['menu_items'] = $query3->rows;

        return $block_data_info;
    }

    public function getTotalProductsByCategoryId($category_id) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "'");

        return $query->row['total'];
    }
}
