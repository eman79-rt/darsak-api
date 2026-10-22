# منصة درسك — Laravel API

مشروع API تعليمي مبني على Laravel 13 وSanctum. جميع المسارات تحت `routes/api.php`، والاستجابات JSON. يتضمن علاقات Polymorphic للتعليقات والصور والتصنيفات، صلاحيات عبر Form Requests، قاعدة تحقق لروابط الفيديو، Scopes، Seeder وطلبات Postman.

## المتطلبات

- PHP 8.3 أو أحدث مع امتدادات Laravel المعتادة وPDO SQLite
- Composer 2

## التشغيل من الصفر

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

تتوفر أسماء دخول Seeder وكلمات المرور في `storage/app/seed-tokens.txt` بعد تنفيذ seed. التوكنان يُولّدان عند كل seed؛ انسخهما إلى متغيري `teacher_token` و`student_token` في Postman.

## المسارات

- `GET /api/courses` عرض الكورسات مع التحميل المسبق للعلاقات وpagination.
- `GET /api/courses/{course}` تفاصيل كورس ودروسه.
- `POST /api/courses` إنشاء كورس للمدرس.
- `PATCH /api/courses/{course}` تعديل كورس المدرس نفسه فقط، وبحقول جزئية.
- `POST /api/courses/{course}/lessons` إنشاء درس في كورس يملكه المدرس.
- `POST /api/courses/{id}/comments` أو `/api/lessons/{id}/comments` إضافة تعليق لطالب مسجل في الكورس.
- `GET /api/categories/{category}/content` جلب الكورسات والدروس والواجبات التابعة للتصنيف.
- `GET /api/teacher/latest-comments` أحدث 30 تعليقًا للمدرس.

كل المسارات تتطلب `Authorization: Bearer <sanctum-token>` و`Accept: application/json`.

## حسابات التجربة

المدرس `teacher@darsak.test`، الطالب `student@darsak.test`، وكلمة المرور للجميع `password`. يعرض Seeder التوكنات المولدة في `storage/app/seed-tokens.txt` محليًا للاختبار.

## التحقق والاختبارات

```bash
php artisan test
```

تُرجع أخطاء البيانات `422` برسائل عربية، وفشل الصلاحيات `403`، والعناصر غير الموجودة `404`. اختبار الفيديو يرفض أي مضيف غير YouTube أو Vimeo.

## ملاحظات تصميمية

- الجداول العامة هي `comments`, `images`, `categories`, `categoryables`؛ أنواع Polymorphic محفوظة بأسماء قصيرة عبر Morph Map.
- التعليقات One-to-Many، الصور One-to-One، والتصنيفات Many-to-Many Polymorphic.
- إضافة Assignment تستخدم traits نفسها دون جداول علاقات جديدة، وقد جهز الموديل والعلاقات والـ Morph Map لها.
- `PublishedCourseScope` يخفي المسودات عن الطلاب، ويُتجاوز صراحة لاستعلام مدرسه.
- `ImageStorage` مربوط بتنفيذ التخزين المحلي عبر Service Container ليسهل استبداله بخدمة خارجية.
- Endpoint آخر التعليقات يستخدم `whereHasMorph` و`morphWith` للتحميل المسبق بحسب النوع؛ عدد الاستعلامات ثابت بحسب أنواع الموديلات الداخلة في النتيجة ولا ينفذ استعلامًا لكل تعليق. افحصه عند الحاجة عبر `DB::listen`.
- لا يتضمن المشروع واجهة Blade.

## Postman

استورد `Postman/Darsak-API.postman_collection.json`. المجموعة تحتوي أمثلة إنشاء كورس وطلب بيانات خاطئة وقائمة الكورسات ولوحة أحدث التعليقات.
