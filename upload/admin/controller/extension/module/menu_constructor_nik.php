<?php
class ControllerExtensionModuleMenuConstructorNik extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/menu_constructor_nik');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('extension/module/menu_constructor_nik');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_menu_constructor_nik', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

        $this->getList();
	}

    public function addMenuItem() {
        $this->load->language('extension/module/menu_constructor_nik');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/menu_constructor_nik');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateMenuItemForm()) {
            $this->model_extension_module_menu_constructor_nik->addMenuItem($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getFormMenuItem();
    }

    public function editMenuItem() {
        $this->load->language('extension/module/menu_constructor_nik');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/menu_constructor_nik');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateMenuItemForm()) {
            $this->model_extension_module_menu_constructor_nik->editMenuItem($this->request->get['menu_item_id'], $this->request->post);


            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getFormMenuItem();
    }

    public function deleteMenuItem() {
        $this->load->language('extension/module/menu_constructor_nik');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/menu_constructor_nik');

        if (isset($this->request->get['menu_item_id']) && $this->validateDelete()) {
            $this->model_extension_module_menu_constructor_nik->deleteMenuItem($this->request->get['menu_item_id']);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getList();
    }

    public function addMenuBlock() {
        $this->load->language('extension/module/menu_constructor_nik');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/menu_constructor_nik');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateMenuItemForm()) {
            $this->model_extension_module_menu_constructor_nik->addMenuBlock($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getFormMenuBlock();
    }

    public function editMenuBlock() {
        $this->load->language('extension/module/menu_constructor_nik');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/menu_constructor_nik');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateMenuBlockForm()) {
            $this->model_extension_module_menu_constructor_nik->editMenuBlock($this->request->get['menu_block_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getFormMenuBlock();
    }

    public function deleteMenuBlock() {
        $this->load->language('extension/module/menu_constructor_nik');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/menu_constructor_nik');

        if (isset($this->request->get['menu_block_id']) && $this->validateDelete()) {
            $this->model_extension_module_menu_constructor_nik->deleteMenuBlock($this->request->get['menu_block_id']);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'mi.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = '';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'], true);

        $data['addMenuItem'] = $this->url->link('extension/module/menu_constructor_nik/addMenuItem', 'user_token=' . $this->session->data['user_token'], true);
        $data['addMenuBlock'] = $this->url->link('extension/module/menu_constructor_nik/addMenuBlock', 'user_token=' . $this->session->data['user_token'], true);
        $data['changeSettings'] = $this->url->link('extension/module/menu_constructor_nik/saveHelpSettings', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        $data['sort_menu_item_name'] = $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . '&sort=mid.name' . $url, true);
        $data['sort_menu_item_sort_order'] = $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . '&sort=mi.sort_order' . $url, true);

        $data['sort_category_title'] = $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . '&sort=hcd.title' . $url, true);
        $data['sort_category_sort_order'] = $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . '&sort=hc.sort_order' . $url, true);

        if (isset($this->request->post['module_menu_constructor_nik_status'])) {
            $data['module_menu_constructor_nik_status'] = $this->request->post['module_menu_constructor_nik_status'];
        } else {
            $data['module_menu_constructor_nik_status'] = $this->config->get('module_menu_constructor_nik_status');
        }

        $filter_data = array(
            'sort'        => $sort,
            'order'       => $order,
            'filter_name' => $filter_name
        );

        $results = $this->model_extension_module_menu_constructor_nik->getMenuItems($filter_data);

        foreach ($results as $result) {
            $data['menu_items'][] = array(
                'menu_item_id'    => $result['menu_item_id'],
                'name'            => $result['name'],
                'sort_order'      => $result['sort_order'],
                'edit'            => $this->url->link('extension/module/menu_constructor_nik/editMenuItem', 'user_token=' . $this->session->data['user_token'] . '&menu_item_id=' . $result['menu_item_id'], true),
                'delete'          => $this->url->link('extension/module/menu_constructor_nik/deleteMenuItem', 'user_token=' . $this->session->data['user_token'] . '&menu_item_id=' . $result['menu_item_id'], true)
            );
        }

        $data['filter_name'] = $filter_name;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/menu_constructor_list_nik', $data));
    }

    protected function getFormMenuItem() {
        $data['text_form'] = !isset($this->request->get['menu_item_id']) ? $this->language->get('text_add_menu_item') : $this->language->get('text_edit_menu_item');

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = array();
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        if (!isset($this->request->get['menu_item_id'])) {
            $data['action'] = $this->url->link('extension/module/menu_constructor_nik/addMenuItem', 'user_token=' . $this->session->data['user_token'] . $url, true);
        } else {
            $data['action'] = $this->url->link('extension/module/menu_constructor_nik/editMenuItem', 'user_token=' . $this->session->data['user_token'] . '&menu_item_id=' . $this->request->get['menu_item_id'] . $url, true);
        }

        $data['cancel'] = $this->url->link('extension/module/menu_constructor_nik', 'user_token=' . $this->session->data['user_token'] . $url, true);

        if (isset($this->request->get['menu_item_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $menu_item_info = $this->model_extension_module_menu_constructor_nik->getMenuItem($this->request->get['menu_item_id']);
            $menu_item_description = $this->model_extension_module_menu_constructor_nik->getMenuItemDescription($this->request->get['menu_item_id']);

            $data['menu'] = $menu_item_info;

            $block_info = $this->model_extension_module_menu_constructor_nik->getBlock($this->request->get['menu_item_id']);

            if ($block_info) {
                $this->load->model('catalog/product');
                $this->load->model('tool/image');

                $block_cols = $this->model_extension_module_menu_constructor_nik->getBlockCols($block_info['id']);

                foreach ($block_cols as $col_id => $block_col) {
                    $block_data_info = $this->model_extension_module_menu_constructor_nik->getBlockData($block_col['id']);

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
                                $results[] = $this->model_extension_module_menu_constructor_nik->getMenuItemName($menu_item['menu_item_id']);
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
                    $block_cols[$col_id]['block_data'] = $block_data_info;
                }

                $block_info['block_cols'] = $block_cols;
            }

            $data['block'] = $block_info;
        }

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['menu_constructor_nik_description'])) {
            $data['menu_constructor_nik_description'] = $this->request->post['menu_constructor_nik_description'];
        } elseif (!empty($menu_item_description)) {
            $data['menu_constructor_nik_description'] = $menu_item_description;
        } else {
            $data['menu_constructor_nik_description'] = array();
        }

        if (isset($this->request->post['parent_id'])) {
            $data['parent_id'] = $this->request->post['parent_id'];
        } elseif (!empty($menu_item_info)) {
            $data['parent_id'] = $menu_item_info['parent_id'];
        } else {
            $data['parent_id'] = 0;
        }

        $data['parents'] = $this->model_extension_module_menu_constructor_nik->getMenuItemsParents();

        if (isset($this->request->get['menu_item_id'])) {
            foreach ($data['parents'] as $parent_key => $parent) {
                if ($parent['menu_item_id'] == $this->request->get['menu_item_id']) {
                    unset($data['parents'][$parent_key]);
                }
            }
        }

        if (isset($this->request->post['sort_order'])) {
            $data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($menu_item_info)) {
            $data['sort_order'] = $menu_item_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($menu_item_info)) {
            $data['status'] = $menu_item_info['status'];
        } else {
            $data['status'] = true;
        }

        $data['categories'] = array();

        $filter_data = array(
            'filter_newsletter' => 1,
            'sort'              => $sort,
            'order'             => $order,
        );

        $this->load->model('catalog/category');

        $categories = $this->model_catalog_category->getCategories($filter_data);

        foreach ($categories as $category) {
            $total_products = $this->model_extension_module_menu_constructor_nik->getTotalProductsByCategoryId($category['category_id']);

            $data['categories'][] = array(
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'total_products' => sprintf($this->language->get('text_total_products'), $total_products)
            );
        }

        $data['child_menu_items_list'] = array();
        $data['parents_menu_items_list'] = array();
        $data['parents_menu_items_list'] = $this->model_extension_module_menu_constructor_nik->getMenuItemsParents();

        if (isset($this->request->get['menu_item_id'])) {
            $data['child_menu_items_list'] = $this->model_extension_module_menu_constructor_nik->getMenuItemsByParentId($this->request->get['menu_item_id']);

            foreach ($data['parents_menu_items_list'] as $key => $menu_item) {
                if ($menu_item['menu_item_id'] == $this->request->get['menu_item_id']) {
                    unset($data['parents_menu_items_list'][$key]);
                }
            }
        }


        $this->load->model('tool/image');
        $data['img_placeholder'] = $this->model_tool_image->resize('no_image.png', 40, 40);
        $data['img_min_placeholder'] = $this->model_tool_image->resize('no_image.png', 20, 20);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/menu_constructor_menu_item_form_nik', $data));
    }

    public function addBlock() {
        if(isset($this->request->get['menu_item_id']) && isset($this->request->get['grid_id']) && $this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/module/menu_constructor_nik');
            $block_id = $this->model_extension_module_menu_constructor_nik->addBlock($this->request->get['menu_item_id'], $this->request->get['grid_id']);
            $this->createCols($block_id, $this->request->get['grid_id']);
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($block_id));
        }
    }

    public function deleteBlock() {
        if(isset($this->request->get['block_id']) && $this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/module/menu_constructor_nik');

            $this->model_extension_module_menu_constructor_nik->deleteBlock($this->request->get['block_id']);
        }
    }

    protected function createCols($block_id, $grid_id) {
        switch ($grid_id) {
            case '1':
                $this->model_extension_module_menu_constructor_nik->addBlockCol(1, $block_id, 'w-100');
                break;
            case '2':
                for ($i = 0; $i < 2; $i++) {
                    $this->model_extension_module_menu_constructor_nik->addBlockCol($i+1, $block_id, 'w-50');
                }
                break;
            case '3':
                for ($i = 0; $i < 3; $i++) {
                    $this->model_extension_module_menu_constructor_nik->addBlockCol($i+1, $block_id, 'w-33');
                }
                break;
            case '4':
                for ($i = 0; $i < 4; $i++) {
                    $this->model_extension_module_menu_constructor_nik->addBlockCol($i+1, $block_id, 'w-25');
                }
                break;
            case '5':
                $this->model_extension_module_menu_constructor_nik->addBlockCol(1, $block_id, 'w-33');
                $this->model_extension_module_menu_constructor_nik->addBlockCol(2, $block_id, 'w-66');
                break;
            case '6':
                $this->model_extension_module_menu_constructor_nik->addBlockCol(1, $block_id, 'w-66');
                $this->model_extension_module_menu_constructor_nik->addBlockCol(2, $block_id, 'w-33');
                break;
            case '7':
                for ($i = 0; $i < 2; $i++) {
                    $this->model_extension_module_menu_constructor_nik->addBlockCol($i+1, $block_id, 'w-25');
                }
                $this->model_extension_module_menu_constructor_nik->addBlockCol(3, $block_id, 'w-50');
                break;
            case '8':
                $this->model_extension_module_menu_constructor_nik->addBlockCol(1, $block_id, 'w-50');
                for ($i = 1; $i < 3; $i++) {
                    $this->model_extension_module_menu_constructor_nik->addBlockCol($i+1, $block_id, 'w-25');
                }
                break;
            case '9':
                $this->model_extension_module_menu_constructor_nik->addBlockCol(1, $block_id, 'w-25');
                $this->model_extension_module_menu_constructor_nik->addBlockCol(2, $block_id, 'w-50');
                $this->model_extension_module_menu_constructor_nik->addBlockCol(3, $block_id, 'w-25');
                break;
            case '10':
                for ($i = 0; $i < 5; $i++) {
                    $this->model_extension_module_menu_constructor_nik->addBlockCol($i+1, $block_id, 'w-20');
                }
                break;
            case '11':
                for ($i = 0; $i < 6; $i++) {
                    $this->model_extension_module_menu_constructor_nik->addBlockCol($i+1, $block_id, 'w-16');
                }
                break;
            case '12':
                $this->model_extension_module_menu_constructor_nik->addBlockCol(1, $block_id, 'w-16');
                $this->model_extension_module_menu_constructor_nik->addBlockCol(2, $block_id, 'w-66');
                $this->model_extension_module_menu_constructor_nik->addBlockCol(3, $block_id, 'w-16');
                break;

            default:
                break;
        }
    }

    public function addBlockData() {
        if(isset($this->request->get['block_id']) && isset($this->request->get['col_id']) && $this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/module/menu_constructor_nik');
            // end this
            $formData = $_POST;
            $formData['block_id'] = $this->request->get['block_id'];
            $formData['block_col_id'] = $this->request->get['col_id'];
            $block = $this->model_extension_module_menu_constructor_nik->getBlockById($this->request->get['block_id']);
            $block_grid_width = '';
            switch ($block['grid_id']) {
                case '1':
                    $block_grid_width = 'w-100';
                    break;
                case '2':
                    $block_grid_width = 'w-50';
                    break;
                case '3':
                    $block_grid_width = 'w-33';
                    break;
                case '4':
                    $block_grid_width = 'w-25';
                    break;
                case '5':
                    if($formData['col_id'] == '1') {
                        $block_grid_width = 'w-33';
                    } else {
                        $block_grid_width = 'w-66';
                    }
                    break;
                case '6':
                    if($formData['col_id'] == '1') {
                        $block_grid_width = 'w-66';
                    } else {
                        $block_grid_width = 'w-33';
                    }
                    break;
                case '7':
                    if($formData['col_id'] == '3') {
                        $block_grid_width = 'w-50';
                    } else {
                        $block_grid_width = 'w-25';
                    }
                    break;
                case '8':
                    if($formData['col_id'] == '1') {
                        $block_grid_width = 'w-50';
                    } else {
                        $block_grid_width = 'w-25';
                    }
                    break;
                case '9':
                    if($formData['col_id'] == '2') {
                        $block_grid_width = 'w-50';
                    } else {
                        $block_grid_width = 'w-25';
                    }
                    break;
                case '10':
                    $block_grid_width = 'w-20';
                    break;
                case '11':
                    $block_grid_width = 'w-16';
                    break;
                case '12':
                    if($formData['col_id'] == '2') {
                        $block_grid_width = 'w-66';
                    } else {
                        $block_grid_width = 'w-16';
                    }
                    break;

                default:
                    break;
            }
            $formData['block_grid_width'] = $block_grid_width;
            $block_data_id = $this->model_extension_module_menu_constructor_nik->addBlockData($formData);
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($block_data_id));
        }
    }

    public function editBlockData() {
        if(isset($this->request->get['block_data_id']) && $this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/module/menu_constructor_nik');
            $formData = $_POST;
            $formData['block_data_id'] = $this->request->get['block_data_id'];
            $this->model_extension_module_menu_constructor_nik->editBlockData($formData);
        }
    }

    public function deleteBlockData() {
        if(isset($this->request->get['block_data_id']) && $this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('extension/module/menu_constructor_nik');

            $this->model_extension_module_menu_constructor_nik->deleteBlockData($this->request->get['block_data_id']);
        }
    }

    public function getBlockData() {
        if(isset($this->request->get['block_data_id']) && $this->request->server['REQUEST_METHOD'] == 'GET') {
            $this->load->model('extension/module/menu_constructor_nik');

            $block_data = $this->model_extension_module_menu_constructor_nik->getBlockDataByBlockDataId($this->request->get['block_data_id']);

            if (isset($block_data['products'])) {
                $results = array();
                $this->load->model('catalog/product');
                foreach ($block_data['products'] as $product) {
                    $results[] = $this->model_catalog_product->getProduct($product['product_id']);
                }

                $json = array();
                $this->load->model('tool/image');

                foreach ($results as $result) {
                    $result['price'] = $this->currency->format($result['price'], $this->config->get('config_currency'));
                    if ($result['image']) {
                        $result['thumb'] = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
                    } else {
                        $result['thumb'] = '';
                    }
                    $json[] = $result;
                }

                $block_data['products'] = $json;
            }

            if (isset($block_data['menu_items'])) {
                $results = array();
                foreach ($block_data['menu_items'] as $menu_item) {
                    $results[] = $this->model_extension_module_menu_constructor_nik->getMenuItemName($menu_item['menu_item_id']);
                }

                $block_data['menu_items'] = $results;
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($block_data));
        }
    }

    public function getProducts() {
        if(isset($this->request->get['category_id'])) {
            $this->load->model('catalog/product');
            $this->load->model('tool/image');

            $results = $this->model_catalog_product->getProductsByCategoryId($this->request->get['category_id']);

            $json = array();

            foreach ($results as $result) {
                $result['price'] = $this->currency->format($result['price'], $this->config->get('config_currency'));
                if ($result['image']) {
                    $result['thumb'] = $this->model_tool_image->resize($result['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_category_height'));
                } else {
                    $result['thumb'] = '';
                }
                $json[] = $result;
            }

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($json));
        }
    }

    public function install() {
        if ($this->user->hasPermission('modify', 'extension/module/menu_constructor_nik')) {
            $this->load->model('extension/module/menu_constructor_nik');

            $this->model_extension_module_menu_constructor_nik->install();
        }
    }

    public function uninstall() {
        if ($this->user->hasPermission('modify', 'extension/module/menu_constructor_nik')) {
            $this->load->model('extension/module/menu_constructor_nik');

            $this->model_extension_module_menu_constructor_nik->uninstall();
        }
    }

	protected function validateMenuItemForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/menu_constructor_nik')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        foreach ($this->request->post['menu_constructor_nik_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 64)) {
                $this->error['name'][$language_id] = $this->language->get('error_menu_item_name');
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/menu_constructor_nik')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/menu_constructor_nik')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}