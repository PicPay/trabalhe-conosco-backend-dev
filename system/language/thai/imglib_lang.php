<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['imglib_source_image_required'] = 'คุณต้องระบุแหล่งที่มาของภาพในการตั้งค่าของคุณ';
$lang['imglib_gd_required'] = 'จำเป็นต้องใช้ GD image สำหรับการทำงานนี้';
$lang['imglib_gd_required_for_props'] = 'เซิร์ฟเวอร์ของคุณต้องสนับสนุน GD image library เพื่อตรวจสอบคุณสมบัติของภาพ';
$lang['imglib_unsupported_imagecreate'] = 'เซิร์ฟเวอร์ของคุณไม่สนับสนุน GD function ซึ่งจำเป็นในการประมวลผลชนิดของภาพนี้';
$lang['imglib_gif_not_supported'] = 'ภาพ GIF มักจะไม่ได้รับการสนับสนุนเนื่องจากข้อจำกัดของใบอนุญาต (license) คุณอาจจะต้องใช้ภาพแบบ JPG หรือ PNG แทน';
$lang['imglib_jpg_not_supported'] = 'ไม่สนับสนุนภาพชนิด JPG';
$lang['imglib_png_not_supported'] = 'ไม่สนับสนุนภาพชนิด PNG';
$lang['imglib_jpg_or_png_required'] = 'วิธีการปรับขนาดภาพที่ระบุไว้ในการตัังค่าของสามารทำงานได้กับภาพประเภท JPEG หรือ PNG เท่านั้น';
$lang['imglib_copy_error'] = 'พบข้อผิดพลาดในขณะที่พยายามที่จะแทนที่แฟ้ม กรุณาตรวจสอบให้แน่ใจไดเรกทอรีไฟล์ของคุณสามารถเขียนได้';
$lang['imglib_rotate_unsupported'] = 'เซิร์ฟเวอร์ของคุณไม่สนับสนุนการหมุนภาพ';
$lang['imglib_libpath_invalid'] = 'Path ไปยัง image libraryของคุณไม่ถูกต้อง กรุณาตั้งค่าเส้นทางที่ถูกต้องในการตั้งค่าภาพของคุณ';
$lang['imglib_image_process_failed'] = 'ล้มเหลวในการประมวลผลภาพ กรุณาตรวจสอบว่าเซิร์ฟเวอร์ของคุณรองรับโปรโตคอลที่ใช้และเส้นทางไปยัง image library ของคุณถูกต้อง';
$lang['imglib_rotation_angle_required'] = 'โปรดระบุมุมของการหมุนภาพ';
$lang['imglib_invalid_path'] = 'ตำแหน่งของภาพไม่ถูกต้อง';
$lang['imglib_copy_failed'] = 'การคัดลอกภาพล้มเหลว';
$lang['imglib_missing_font'] = 'ไม่พบฟ้อนต์ที่ต้องการ';
$lang['imglib_save_failed'] = 'ไม่สามารถบันทึกภาพ กรุณาตรวจสอบภาพและไดเรกทอรีของแฟ้มว่าสามารถเขียนได้หรือไม่';

/* End of file imglib_lang.php */
/* Location: ./application/language/thai/imglib_lang.php */