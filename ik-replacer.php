<?php
/**
 * Plugin name: IK Replacer
 * Plugin URI: https://sitepro4web.com/
 * Description:  IK Replacer - test plugin to replace text with a random value  in the content for а post by id.
 * Version: 1.0.0
 * Author: Ihor Khaletskyi
 * Author URI: https://sitepro4web.com/
 * Licence: GPL2
 * Text Domain: ik-replacer
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
Copyright 2005-2015 Automattic, Inc.
*/


defined( 'ABSPATH' ) or die( 'Hey, you can\t access this file!' );

define( 'IK_REPLACER_PATH', plugin_dir_path( __FILE__ ) );
define( 'IK_REPLACER_URL', plugin_dir_url( __FILE__ ) );

require IK_REPLACER_PATH . 'vendor/autoload.php';

use App\Replacer;

$replacer = new Replacer();
