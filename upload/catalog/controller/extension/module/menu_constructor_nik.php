<?php
class ControllerExtensionModuleMenuConstructorNik extends Controller {
	public function index() {
//		$this->load->language('extension/module/account');
		$this->load->model('extension/module/menu_constructor_nik');

		$data = array();

		$menu_items = $this->model_extension_module_menu_constructor_nik->getMenuItems();

        foreach ($menu_items as $menu_item_key => $menu_item) {
            if (!empty($menu_item)) {
                $menu_item_info = $menu_item;

                $block_info = $this->model_extension_module_menu_constructor_nik->getBlock($menu_item['menu_item_id']);

                if ($block_info) {
                    $this->load->model('catalog/product');
                    $this->load->model('tool/image');

                    $block_data_info = $this->model_extension_module_menu_constructor_nik->getBlockData($block_info['id']);

                    foreach ($block_data_info as $kk => $block_data) {
                        $contents = array();
                        if (!empty($block_data['text'])) {
                            $contents[] = array(
                                'value'   => $block_data['text'],
                                'sort'    => $block_data['text_ordinal'],
                                'type'    => 'text'
                            );
                        }

                        if (!empty($block_data['products'])) {
                            $results = array();
                            foreach ($block_data['products'] as $product) {
                                $results[] = $this->model_catalog_product->getProduct($product['product_id']);
                            }

                            foreach ($results as $kkk => $result) {
                                $results[$kkk]['price'] = $this->currency->format($result['price'], $this->config->get('config_currency'));
                                if ($results[$kkk]['image']) {
                                    $results[$kkk]['thumb'] = $this->model_tool_image->resize($result['image'], 133, 133);
                                } else {
                                    $results[$kkk]['thumb'] = $this->model_tool_image->resize('no_image.png', 133, 133);
                                }
                                $results[$kkk]['href'] = $this->url->link('product/product', 'product_id=' . $result['product_id']);
                            }

                            if (!empty($results)) {
                                $contents[] = array(
                                    'value'   => $results,
                                    'sort'    => $block_data['products_ordinal'],
                                    'type'    => 'products'
                                );
                            }
                        }

                        if (!empty($block_data['menu_items'])) {
                            $results = array();
                            foreach ($block_data['menu_items'] as $menu_item) {
                                $results[] = $this->model_extension_module_menu_constructor_nik->getMenuItemInfo($menu_item['menu_item_id']);
                            }

                            if (!empty($results)) {
                                $contents[] = array(
                                    'value'   => $results,
                                    'sort'    => $block_data['menu_items_ordinal'],
                                    'type'    => 'menu_items'
                                );
                            }
                        }

                        $sort_order = array();

                        foreach ($contents as $key => $value) {
                            $sort_order[$key] = $value['sort'];
                        }

                        array_multisort($sort_order, SORT_ASC, $contents);

                        $block_data_info[$kk]['contents'] = $contents;
                    }

                    $block_info['blocks_data'] = $block_data_info;
                }

                $menu_items[$menu_item_key]['block'] = $block_info;
            }
		}

//        echo "<pre>";
//        foreach ($menu_items as $menu_item) {
//            print_r($menu_item['block']);
//        }
//        print_r($menu_items);
//        echo "</pre>";

        $data['menu'] = $menu_items;

		return $this->load->view('extension/module/menu_constructor_nik', $data);
	}
}