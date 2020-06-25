<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

function history($desc = NULL) {
	$CI = &get_instance();
	$path = $CI->uri->segment(1);
	$user = $CI->session->userdata('ses_username');
	$ip = $CI->input->ip_address();
	$os = $CI->agent->platform();

	if ($CI->agent->is_browser()) {
		$browser = $CI->agent->browser() . ' ' . $CI->agent->version();
	} elseif ($CI->agent->is_mobile()) {
		$browser = $CI->agent->mobile();
	} else {
		$browser = 'data user gagal di dapatkan';
	}
	$date = date('Y-m-d H:i:s');

	$data = array(
		'username' => $user,
		'path' => $path,
		'description' => $desc,
		'created' => $date,
		'ip' => $ip,
		'os' => $os,
		'browser' => $browser,
	);

	$CI->db->insert('histories', $data);
}

function application($string) {
	$CI = &get_instance();
	$val = $CI->db->get('application')->row();

	if ($string == 'app_name') {
		$result = $val->app_name;
	} else if ($string == 'app_first_name') {
		$name = $val->app_name;
		$name_arr = explode(' ', $name);
		$result = $name_arr[0];

	} else if ($string == 'app_mid_name') {
		$name = $val->app_name;
		$name_arr = explode(' ', $name);
		$result = " " . $name_arr[1];

	} else if ($string == 'app_last_name') {
		$name = $val->app_name;
		$name_arr = explode(' ', $name);
		$result = " " . $name_arr[2];
	} else if ($string == 'app_detail') {
		$result = $val->app_detail;
	} else if ($string == 'version') {
		$result = $val->version;
	} else if ($string == 'build_date') {
		$result = $val->build_date;
	}

	return $result;
}

function dump($data) {
	echo "<br><br><br><br>";
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	// echo "<br>";
}

function dd($data) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die();
}

function encrypt($data) {
	$string = "BTS";
	$base_64 = urlencode(base64_encode($data . $string));
	return $base_64;
}

function decrypt($data) {
	$string = base64_decode(urldecode($data));
	$rtn = str_replace('BTS', '', $string);
	return $rtn;
}

function view_date($date) {
	if (!empty($date) && $date != '0000-00-00') {
		return date('d/m/Y', strtotime($date));
	}
}

function save_date($date) {
	if (!empty($date) && $date != '0000-00-00') {
		return date('Y-m-d', strtotime($date));
	}
}

function view_datetime($date) {
	if (!empty($date) && $date != '0000-00-00 00:00:00') {
		return date('d/m/Y H:i:s', strtotime($date));
	}
}

function save_datetime($date) {
	if (!empty($date) && $date != '0000-00-00 00:00:00') {
		return date('Y-m-d H:i:s', strtotime($date));
	}
}

function urut($no) {
	return $no++;
}

function breadcrumb($path = '', $action = '') {
	$CI = &get_instance();
	$html = '';
	$query = $CI->db->query("SELECT parent.name AS parent_name, parent.path AS parent_path, menu.name, menu.path FROM menu
								 INNER JOIN menu AS parent ON menu.parent_id = parent.menu_id AND parent.parent_id = 0 WHERE menu.path = '" . $path . "' ");
	$value = $query->row();
	if (!empty($value)) {
		$html .= '<ol class="breadcrumb bc-3">
				      <li>
				        <a href="' . site_url('dashboard') . '"><i class="entypo-home"></i>Dashboard</a>
				      </li>';
		if (!empty($value->parent_name)) {
			$html .= '<li>
			            <a href="' . site_url($value->parent_path) . '">' . $value->parent_name . '</a>
				      </li>';
		}
		if (!empty($value->name)) {
			$html .= '<li>
				          <a href="' . site_url($value->path) . '">' . $value->name . '</a>
				      </li>';
		}
		if ($action != '' && ($action == 'add' || $action == 'edit' || $action == 'access menu')) {
			$html .= '<li>
				          <a href="javascript:void(0);">' . ucwords($action) . '</a>
				      </li>';
		}
		$html .= '</ol>';
	} else {
		$html .= '<ol class="breadcrumb bc-3">
				      <li>
				        <a href="' . site_url('dashboard') . '"><i class="entypo-home"></i>Dashboard</a>
				      </li>';
		$html .= '</ol>';
	}

	return $html;
}

function menu_name($path = '') {
	$CI = &get_instance();
	$query = $CI->db->query("SELECT name FROM menu WHERE `path`='" . $path . "' ");
	$value = $query->row();
	$name = "Blank";
	if (!empty($value)) {
		$name = $value->name;
	}
	return $name;
}

function top_menu() {
	$CI = &get_instance();
	$html = '';

	$arr_parent = parent_menu();
	$html .= '<ul class="navbar-nav">';
	foreach ($arr_parent as $key => $parent) {
		$url_parent = ($parent['path'] == 'javascript:void(0)') ? $parent['path'] : site_url($parent['path']);
		$html .= '<li>
						    <a href="' . $url_parent . '">
						      <i class="fa ' . $parent['icon'] . '"></i>
						      <span>' . $parent['name'] . '</span>
						    </a>';

		#child 1
		$arr_child1 = child_menu($parent['menu_id']);
		if (!empty($arr_child1)) {
			$html .= '<ul>';
			foreach ($arr_child1 as $key => $child1) {
				$url_child1 = ($child1['path'] == 'javascript:void(0)') ? $child1['path'] : site_url($child1['path']);
				$html .= '<li>
							        <a href="' . $url_child1 . '">
							          <span>' . $child1['name'] . '</span>
							        </a>';

				#child 2
				$arr_child2 = child_menu($child1['menu_id']);
				if (!empty($arr_child2)) {
					$html .= '<ul>';
					foreach ($arr_child2 as $key => $child2) {
						$url_child2 = ($child2['path'] == 'javascript:void(0)') ? $child2['path'] : site_url($child2['path']);
						$html .= '<li>
									        <a href="' . $url_child2 . '">
									          <span>' . $child2['name'] . '</span>
									        </a>';
						$html .= '</li>';
					}
					$html .= '</ul>';
				}
				$html .= '</li>';
			}
			$html .= '</ul>';
		}
		$html .= '</li>';

	}
	$html .= '<li id="search" class="search-input-collapsed">
				    <form method="get" action="">
				      <input type="text" name="q" class="search-input" placeholder="Search something..."/>
				      <button type="submit">
				        <i class="entypo-search"></i>
				      </button>
				    </form>
				  </li>';
	$html .= '</ul>';

	return $html;
}

function parent_menu() {
	$CI = &get_instance();
	$group_id = $CI->session->userdata('ses_groupid');
	$group = $CI->db->get_where('group', array('group_id' => $group_id))->row();
	$all_access = $group->flag_all;
	if ($all_access == 'Y') {
		$CI->db->select('*');
		$CI->db->from('menu');
		$CI->db->where('parent_id', '0');
		$CI->db->where('flag_active', 'Y');
		$CI->db->order_by('weight', 'ASC');
		$result = $CI->db->get()->result_array();
	} else {
		$CI->db->select('*');
		$CI->db->from('menu');
		$CI->db->join('group_menu', 'menu.menu_id = group_menu.menu_id');
		$CI->db->where('menu.parent_id', '0');
		$CI->db->where('menu.flag_active', 'Y');
		$CI->db->where('group_menu.group_id', $group_id);
		$CI->db->where('group_menu.view', 'Y');
		$CI->db->order_by('menu.weight', 'ASC');
		$result = $CI->db->get()->result_array();
	}

	return $result;
}

function child_menu($parent_id) {
	$CI = &get_instance();
	$group_id = $CI->session->userdata('ses_groupid');
	$group = $CI->db->get_where('group', array('group_id' => $group_id))->row();
	$all_access = $group->flag_all;
	if ($all_access == 'Y') {
		$CI->db->select('*');
		$CI->db->from('menu');
		$CI->db->where('parent_id', $parent_id);
		$CI->db->where('flag_active', 'Y');
		$CI->db->order_by('weight', 'ASC');
		$result = $CI->db->get()->result_array();
	} else {
		$CI->db->select('*');
		$CI->db->from('menu');
		$CI->db->join('group_menu', 'menu.menu_id = group_menu.menu_id');
		$CI->db->where('menu.parent_id', $parent_id);
		$CI->db->where('menu.flag_active', 'Y');
		$CI->db->where('group_menu.group_id', $group_id);
		$CI->db->where('group_menu.view', 'Y');
		$CI->db->order_by('menu.weight', 'ASC');
		$result = $CI->db->get()->result_array();
	}

	return $result;
}
//TEST
?>