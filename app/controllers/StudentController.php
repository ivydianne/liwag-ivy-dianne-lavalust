<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
class StudentController extends Controller
{
 public function index()
 {
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}

	$_SESSION['student_access'] = true;

	$this->call->view('student_home');
 }

 public function profile()
 {
	$student = [
		'student_id' => 'MCC2024-00152',
		'name' => 'Ivy Dianne Liwag',
		'course' => 'BS Information Technology',
		'year' => '3rd Year',
		'section' => '3-F4',
		'email' => 'ivydianneliwag1@gmail.com'
	];

	$this->call->view('student_profile', $student);
 }
}