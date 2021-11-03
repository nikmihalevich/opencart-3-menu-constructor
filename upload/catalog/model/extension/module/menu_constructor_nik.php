<?php
class ModelExtensionModuleMenuConstructorNik extends Model {
    public function getMenuItems() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mid.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mi.parent_id = '0' AND mi.status = '1' ORDER BY mi.sort_order");

        return $query->rows;
    }

    public function getMenuItemInfo($menu_item_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item mi LEFT JOIN " . DB_PREFIX . "menu_item_description mid ON (mi.menu_item_id = mid.menu_item_id) WHERE mi.menu_item_id = '" . (int)$menu_item_id . "' AND mid.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getBlock($menu_item_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block WHERE `menu_item_id` = '" . (int)$menu_item_id . "'");

        return $query->row;
    }

    public function getBlockData($block_col_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block_data WHERE `block_col_id` = '" . (int)$block_col_id . "' ORDER BY `sort_ordinal`, `id`");

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

    public function getMenuItemName($menu_item_id) {
        $query = $this->db->query("SELECT `menu_item_id`, `name` FROM " . DB_PREFIX . "menu_item_description WHERE `menu_item_id` = '" . (int)$menu_item_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') ."'");

        return $query->row;
    }

    public function getBlockCols($block_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "menu_item_block_col WHERE `block_id` = '" . (int)$block_id . "'");

        return $query->rows;
    }
}
