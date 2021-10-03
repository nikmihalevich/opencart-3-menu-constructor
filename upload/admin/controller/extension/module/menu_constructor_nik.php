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
            'sort'  => $sort,
            'order' => $order,
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

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/menu_constructor_list_nik', $data));
    }

    protected function getFormMenuItem() {
        $data['text_form'] = !isset($this->request->get['menu_item_id']) ? $this->language->get('text_add_menu_item') : $this->language->get('text_edit_menu_item');

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

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/menu_constructor_menu_item_form_nik', $data));
    }

    protected function getFormMenuBlock() {
        $data['text_form'] = !isset($this->request->get['menu_block_id']) ? $this->language->get('text_add_menu_block') : $this->language->get('text_edit_menu_block');

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

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/menu_constructor_menu_item_form_nik', $data));
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