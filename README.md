# WeCrochet
A PHP/MySQL based e-commerce web application for handmade crochet products featuring user authentication, category filtering, shopping cart management, wishlist, and dynamic product reviews.  
# 🧶 WeCrochet - E-Commerce Platform

**WeCrochet** هو مشروع متجر إلكتروني متكامل مخصص لبيع منتجات الكروشيه المصنوعة يدوياً (ألعاب، ورد، ميداليات، وغيرها). تم تطوير الموقع باستخدام PHP و MySQL مع تطبيق قواعد الحماية وإدارة الجلسات والتعامل الديناميكي مع قاعدة البيانات.

---

## 📸 Key Features | المميزات الرئيسية

* **Authentication & Session Control:** حماية كاملة للصفحات وإجبار المستخدم على تسجيل الدخول قبل التصفح.
* **Dynamic Product Catalog:** عرض المنتجات والتصنيفات ديناميكياً من قاعدة البيانات.
* **Categories & Filtering:** إمكانية تصفح المنتجات حسب الفئات (`Categories`).
* **Interactive Wishlist:** إضافة وحفظ المنتجات المفضلة.
* **Shopping Cart System:** إدارة السلة وحساب التكلفة الإجمالية والتحقق المباشر من كميات المخزون المتاح (`P_Stock`).
* **Product Reviews & Ratings:** إضافة التقييمات والتعليقات وحساب متوسط التقييم بالنجوم أوتوماتيكياً لكل منتج.
* **Search Functionality:** البحث عن المنتجات بسهولة من شريط البحث العلوي.

---

## 🛠️ Tech Stack | التقنيات المستخدمة

* **Front-End:** HTML5, CSS3, JavaScript
* **Back-End:** PHP (Native)
* **Database:** MySQL
* **Server Environment:** XAMPP (Apache & MySQL)

---

## 🗄️ Database Architecture | هيكل قاعدة البيانات

تحتوي قاعدة البيانات `wecrochet` على 4 جداول رئيسية مترابطة:

1. **`products`**: تخزين بيانات المنتجات (`P_ID`, `P_Name`, `P_Price`, `P_Stock`, `P_Image`, `P_Description`, `P_Category`).
2. **`reviews`**: تخزين التقييمات والآراء وهي مربوطة بمفتاح أجنبي مع جدول المنتجات (`FOREIGN KEY` - `ON DELETE CASCADE`).
3. **`wishlist`**: تخزين المنتجات المفضلة للمستخدمين ومربوطة بـ `P_ID`.
4. **`admin`**: تخزين بيانات المشرفين لتسجيل الدخول والتحكم.

---

## 🚀 How to Run the Project | طريقة التشغيل

1. **تشغيل السيرفر:** قم بتشغيل سيرفر Apache و MySQL من تطبيق **XAMPP**.
2. **إعداد قاعدة البيانات:**
   * افتح `http://localhost/phpmyadmin`.
   * أنشئ قاعدة بيانات جديدة باسم `wecrochet`.
   * قم باستيراد (Import) ملف الـ SQL الخاص بالمشروع.
3. **وضع الملفات:** ضع مجلد المشروع `WeCrochet` داخل المسار:  
   `C:\xampp\htdocs\`
4. **فتح الموقع:** افتح المتصفح وانتقل للرابط:  
   `http://localhost/WeCrochet/pages/LogIn_Admin.php`

---

## 👥 Contributors | فريق العمل

* Mariam Sherif
* Hana Mohamed Mokhles
* Malak Wael
