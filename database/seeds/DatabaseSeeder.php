<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    private $countries = array(
        'المملكة العربية السعودية',
    );

    private $cities = array(
        ['cities' => array(
            'تبوك',
            'الرياض',
            'الطائف',
            'مكة المكرمة',
            'حائل',
            'بريدة',
            'الهفوف',
            'الدمام',
            'المدينة المنورة',
            'ابها',
            'جازان',
            'جدة',
            'المجمعة',
            'الخبر',
            'حفر الباطن',
            'خميس مشيط',
            'احد رفيده',
            'القطيف',
            'عنيزة',
            'قرية العليا',
            'الجبيل',
            'النعيرية',
            'الظهران',
            'الوجه',
            'بقيق',
            'الزلفي',
            'خيبر',
            'الغاط',
            'املج',
            'رابغ',
            'عفيف',
            'ثادق',
            'سيهات',
            'تاروت',
            'ينبع',
            'شقراء',
            'الدوادمي',
            'الدرعية',
            'القويعية',
            'المزاحمية',
            'بدر',
            'الخرج',
            'الدلم',
            'الشنان',
            'الخرمة',
            'الجموم',
            'المجاردة',
            'السليل',
            'تثليث',
            'بيشة',
            'الباحة',
            'القنفذة',
            'محايل',
            'ثول',
            'ضبا',
            'تربه',
            'صفوى',
            'عنك',
            'طريف',
            'عرعر',
            'القريات',
            'سكاكا',
            'رفحاء',
            'دومة الجندل',
            'الرس',
            'المذنب',
            'الخفجي',
            'رياض الخبراء',
            'البدائع',
            'رأس تنورة',
            'البكيرية',
            'الشماسية',
            'الحريق',
            'حوطة بني تميم',
            'ليلى',
            'بللسمر',
            'شرورة',
            'نجران',
            'صبيا',
            'ابو عريش',
            'صامطة',
            'احد المسارحة',
            'مدينة الملك عبدالله الاقتصادية',
        )],
    );

    private $nationalities = array(
        'JO' => 'أردني',
        'AE' => 'إماراتي',
        'BH' => 'بحريني',
        'DZ' => 'جزائري',
        'SD' => 'سوداني',
        'SO' => 'صومالي',
        'CN' => 'صيني',
        'IQ' => 'عراقي',
        'KW' => 'كويتي',
        'MA' => 'مغربي',
        'SA' => 'سعودي',
        'YE' => 'يمني',
        'TR' => 'تركي',
        'TD' => 'تشادي',
        'TN' => 'تونسي',
        'SY' => 'سوري',
        'OM' => 'عماني',
        'PS' => 'فلسطيني',
        'QA' => 'قطري',
        'LB' => 'لبناني',
        'ML' => 'مالي',
        'MY' => 'ماليزي',
        'EG' => 'مصري',
        'NG' => 'نيجيري',
    );

    private $genders = array(
        'MALE' => 'ذكز',
        'FEMALE' => 'أثنى',
    );

    private $templates = array(
        'first' => 'القالب الأول',
        'second' => 'القالب الثانية',
        'third' => 'القالب الثالثة',
    );

    private $titles = array(
        1 => ' السيد/ة',
        2 => ' الأستاذ/ة',
        3 => ' الدكتور/ة',
        4 => ' المهندس/ة',
        5 => ' الفنان/ة',
        6 => ' المستشار/ة',
        7 => ' معالي الشيخ/ة',
    );

    private $roles = array(
        1 => 'administrator',
        2 => 'center',
        3 => 'admin',
        4 => 'trainer',
        5 => 'student',
    );

    private $social_media = array(
        ['name' => 'Twitter', 'link' => 'https://www.twitter.com/', 'class' => 'social-twitter', 'image' => 'img/main/twitter.png'],
        ['name' => 'Facebook', 'link' => 'https://www.facebook.com/', 'class' => 'social-facebook', 'image' => 'img/main/facebook.png'],
        ['name' => 'Snapchat', 'link' => 'https://www.snapchat.com/add/', 'class' => 'social-snapchat', 'image' => 'img/main/snapchat.png'],
        ['name' => 'Instagram', 'link' => 'https://www.instagram.com/', 'class' => 'social-instagram', 'image' => 'img/main/instagram.png'],
    );

    private $banks = array(
        ['name' => 'البنك الأهلي التجاري', 'image' => 'img/main/',],
        ['name' => 'البنك السعودي البريطاني', 'image' => 'img/main/',],
        ['name' => 'البنك السعودي الفرنسي', 'image' => 'img/main/',],
        ['name' => 'البنك الأول', 'image' => 'img/main/',],
        ['name' => 'البنك السعودي للاستثمار', 'image' => 'img/main/',],
        ['name' => 'البنك العربي الوطني', 'image' => 'img/main/',],
        ['name' => 'بنك البلاد', 'image' => 'img/main/',],
        ['name' => 'بنك الجزيرة', 'image' => 'img/main/',],
        ['name' => 'بنك الرياض', 'image' => 'img/main/',],
        ['name' => 'مجموعة سامبا المالية (سامبا)', 'image' => 'img/main/',],
        ['name' => 'مصرف الراجحي', 'image' => 'img/main/',],
        ['name' => 'مصرف الإنماء', 'image' => 'img/main/',],
    );

    private $categories = array(
        1 => 'تدريب المدربين',
        2 => 'الإدارة',
        3 => 'المالية والمحاسبة',
        4 => 'بنوك وتأمين',
        5 => 'الحاسب وتقنية المعلومات',
        6 => 'لغات وترجمة',
        7 => 'تطوير ذات',
        8 => 'رسم وفنون وتصميم',
        9 => 'القيادة',
        10 => 'الأسرة والطفل',
        11 => 'قانون',
        12 => 'طب و أسعافات الأولية',
        13 => 'امن وسلامة',
        14 => 'رياضة ولياقة',
        15 => 'نظام العمل',
        16 => 'علاقات دوليه ودبلوماسية',
        17 => 'رحلات تدريبية',
        18 => 'تعليم وتربية',
        19 => 'ريادة أعمال',
        20 => 'سكرتارية',
        21 => 'تصميم حقائب تدريب',
        22 => 'العلاقات العامة والاعلام',
        23 => 'الجودة',
        24 => 'صيانة الجوالات',
        25 => 'اللوجستيات وسلاسل الإمداد',
        26 => 'إدارة مشاريع',
        27 => 'مكياج',
        28 => 'تسويق ومبيعات',
        29 => 'التدريب الشخصي الكوتشينج',
        30 => 'تصميم هندسي',
        31 => 'التخطيط الأستراتيجي',
        32 => 'التصوير والإخراج',
        33 => 'معرض عالم التطبيقات',
        34 => 'العرض والإلقاء',
        35 => 'إدارة الفعاليات والمؤتمرات',
        36 => 'العروض الخاصة',
        37 => 'الخلطات والعطور',
        38 => 'معرض سعودي موبايل شو',
        39 => 'الموارد البشرية',
        40 => 'دورات الشرعية',
    );

    public function run()
    {

        // Initialize Country Default Data
        foreach ($this->countries as $country) {
            DB::table('countries')->insert([
                'name' => $country,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        // Initialize Cities Default Data
        for ($i = 0; $i < count($this->countries); $i++) {
            for ($x = 0; $x < count($this->cities[$i]['cities']); $x++) {
                DB::table('cities')->insert([
                    'country_id' => ($i + 1),
                    'name' => $this->cities[$i]['cities'][$x],
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }


        // Initialize Nationality Default Data
        foreach ($this->nationalities as $nationality) {
            DB::table('nationalities')->insert([
                'name' => $nationality,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        // Initialize Genders Default Data
        foreach ($this->genders as $gender) {
            DB::table('genders')->insert([
                'name' => $gender,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        // Initialize Templates Default Data
        foreach ($this->templates as $template) {
            DB::table('templates')->insert([
                'name' => $template,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        // Initialize Titles Default Data
        foreach ($this->titles as $title) {
            DB::table('titles')->insert([
                'name' => $title,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        // Initialize Roles Default Data
        foreach ($this->roles as $role) {
            DB::table('roles')->insert([
                'name' => $role,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        // Initialize Social Media Default Data
        for ($i = 0; $i < count($this->social_media); $i++) {
            DB::table('social_media')->insert([
                'name' => $this->social_media[$i]['name'],
                'link' => $this->social_media[$i]['link'],
                'class' => $this->social_media[$i]['class'],
                'image' => $this->social_media[$i]['image'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }


        // Initialize Banks Default Data
        for ($i = 0; $i < count($this->banks); $i++) {
            DB::table('banks')->insert([
                'name' => $this->banks[$i]['name'],
                'image' => $this->banks[$i]['image'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }

        // Initialize Categories Default Data
        foreach ($this->categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }



        // For The Administrator
        DB::table('users')->insert([
            'username' => 'administrator',
            'email' => 'administrator@gmail.com',
            'phone' => '590000000',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role_id' => 1,
            'status' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // For The Administrator
        DB::table('administrators')->insert([
            'user_id' => 1,
            'name' => 'حامد المالكي',
            'image' => 'default.jpg',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


    }
}
