# Task Management API

REST API لإدارة المهام (CRUD) مبني بـ Laravel.

## المتطلبات
- PHP 8.2+
- Composer
- MySQL

## طريقة التشغيل
```bash
git clone https://github.com/MousaBhar/laravel-task-manager.git
cd laravel-task-manager
composer install
cp .env.example .env
php artisan key:generate
# عدّل بيانات قاعدة البيانات في ملف .env
php artisan migrate
php artisan serve
```

## الـ Endpoints
| Method | URL | الوصف |
|---|---|---|
| GET | /api/tasks | عرض كل المهام (فلتر اختياري `?status=`) |
| POST | /api/tasks | إنشاء مهمة |
| GET | /api/tasks/{id} | عرض مهمة |
| PUT/PATCH | /api/tasks/{id} | تعديل مهمة |
| DELETE | /api/tasks/{id} | حذف مهمة |

## قواعد التحقق
- `title`: مطلوب، نص، حتى 150 حرفًا
- `description`: اختياري
- `status`: pending أو in_progress أو completed
- `due_date`: تاريخ صحيح (اختياري)

> أرسل الهيدر `Accept: application/json` في كل طلب.

## الـ Bonus: الفلتر
- `GET /api/tasks` يعرض كل المهام
- `GET /api/tasks?status=completed` يعرض المكتملة فقط

## نتائج الاختبار
لقطات Postman للسيناريوهات في مجلد `screenshots/`.