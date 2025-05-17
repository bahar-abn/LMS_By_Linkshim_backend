<?php
class CourseController {
    private $courseModel;
    private $enrollmentModel;
    private $categoryModel;
    
    public function __construct() {
        $this->courseModel = new Course();
        $this->enrollmentModel = new Enrollment();
        $this->categoryModel = new Category();
    }
    
    public function index() {
        if(!isLoggedIn()) {
            redirect('login');
        }
        $courses = $this->courseModel->getApprovedCourses();
        $data = [
            'courses' => $courses
        ];

        if($_SESSION['user_role'] == 'instructor') {
            $instructorCourses = $this->courseModel->getInstructorCourses($_SESSION['user_id']);
            $data['instructor_courses'] = $instructorCourses;
            view('courses/instructor_index', $data);
        } elseif($_SESSION['user_role'] == 'student') {
            $enrolledCourses = $this->enrollmentModel->getStudentCourses($_SESSION['user_id']);
            $data['enrolled_courses'] = $enrolledCourses;
            view('courses/student_index', $data);
        } else {
            view('courses/index', $data);
        }
    }
    
    public function create() {
        if(!isLoggedIn() || $_SESSION['user_role'] != 'instructor') {
            redirect('login');
        }
        
        $categories = $this->categoryModel->getAllCategories();
        $data = [
            'categories' => $categories,
            'title' => '',
            'description' => '',
            'category_id' => '',
            'title_err' => '',
            'description_err' => '',
            'category_err' => ''
        ];
        
        view('courses/create', $data);
    }
    
    public function store() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!isLoggedIn() || $_SESSION['user_role'] != 'instructor') {
                redirect('login');
            }
            
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'category_id' => trim($_POST['category_id']),
                'instructor_id' => $_SESSION['user_id'],
                'categories' => $this->categoryModel->getAllCategories(),
                'title_err' => '',
                'description_err' => '',
                'category_err' => ''
            ];
            
            if(empty($data['title'])) {
                $data['title_err'] = 'لطفا عنوان دوره را وارد کنید';
            }
            
            if(empty($data['description'])) {
                $data['description_err'] = 'لطفا توضیحات دوره را وارد کنید';
            }
            
            if(empty($data['category_id'])) {
                $data['category_err'] = 'لطفا دسته‌بندی را انتخاب کنید';
            }
            
            if(empty($data['title_err']) && empty($data['description_err']) && empty($data['category_err'])) {
                if($this->courseModel->createCourse($data)) {
                    flash('course_message', 'دوره با موفقیت ایجاد شد و در انتظار تایید مدیر است');
                    redirect('courses');
                } else {
                    die('خطایی رخ داده است');
                }
            } else {
                view('courses/create', $data);
            }
        } else {
            redirect('courses/create');
        }
    }

    public function show($id) {
        if(!isLoggedIn()) {
            redirect('login');
        }
        
        $course = $this->courseModel->getCourseById($id);
        
        if(!$course || $course->status != 'approved') {
            redirect('courses');
        }
        
        $isEnrolled = false;
        if($_SESSION['user_role'] == 'student') {
            $isEnrolled = $this->enrollmentModel->isEnrolled($_SESSION['user_id'], $id);
        }
        
        $data = [
            'course' => $course,
            'is_enrolled' => $isEnrolled
        ];
        
        view('courses/details', $data);
    }
    
    public function enroll($course_id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!isLoggedIn() || $_SESSION['user_role'] != 'student') {
                redirect('login');
            }
            
            if($this->enrollmentModel->enroll($_SESSION['user_id'], $course_id)) {
                flash('course_message', 'ثبت‌نام در دوره با موفقیت انجام شد');
                redirect('courses/' . $course_id);
            } else {
                flash('course_message', 'شما قبلاً در این دوره ثبت‌نام کرده‌اید', 'alert alert-danger');
                redirect('courses/' . $course_id);
            }
        } else {
            redirect('courses');
        }
    }
}
?>
