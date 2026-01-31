<?php
namespace App\Controllers;

use App\Models\Student;
use Faker\Factory;

class HomeController {
    public function index() {
        // 1. Chuẩn bị dữ liệu
        $message = "Chào mừng đến với MVC!";
        
        // Lấy dữ liệu từ Model Student
        $students = (new Student())->getAllStudents();
        $studentInfo = "Tìm thấy " . count($students) . " sinh viên trong cơ sở dữ liệu.";

        // Sử dụng Faker để tạo dữ liệu giả
        $faker = Factory::create('vi_VN'); // Sử dụng locale Việt Nam
        $fakeUser = [
            'name' => $faker->name,
            'address' => $faker->address,
            'email' => $faker->email
        ];

        // 2. Gọi View
        include 'views/home.php';
    }
}