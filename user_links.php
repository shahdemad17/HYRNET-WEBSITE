<?php
// user_links.php

function safe($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// نحدد الصفحة الحالية من الـ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'saved';

// محتوى كل صفحة مع تفاصيل مخصصة
$pages = [
    'saved' => 'Here you can find all your saved items like posts, articles, and more.',
    'groups' => 'This is where your groups are listed. Join discussions and connect with people.',
    'newsletters' => 'Get the latest updates, news, and offers from our newsletter subscriptions.',
    'events' => 'Upcoming events will be listed here. Stay tuned for important dates and happenings.'
];

// تحقق من أن الصفحة موجودة
$content = isset($pages[$page]) ? $pages[$page] : 'Page not found.';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Links</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .nav {
            margin-bottom: 20px;
        }

        .nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #007BFF;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .event-list,
        .group-list,
        .newsletter-list {
            list-style-type: none;
            padding: 0;
        }

        .event-item,
        .group-item,
        .newsletter-item {
            background: #e9ecef;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .event-item:hover,
        .group-item:hover,
        .newsletter-item:hover {
            background: #d6d8db;
        }
    </style>
</head>

<body>

    <div class="nav">
        <!-- الروابط كما هي مع معلمة الصفحة -->
        <a href="javascript:void(0)" class="nav-link" data-page="saved">📌 Saved Items</a>
        <a href="javascript:void(0)" class="nav-link" data-page="groups">👥 Groups</a>
        <a href="javascript:void(0)" class="nav-link" data-page="newsletters">📰 Newsletters</a>
        <a href="javascript:void(0)" class="nav-link" data-page="events">📅 Events</a>
    </div>

    <div class="content" id="content">
        <!-- سيتم تحميل المحتوى هنا بواسطة AJAX -->
    </div>

    <script>
        $(document).ready(function() {
            // عند الضغط على رابط، نقوم بجلب المحتوى عبر AJAX
            $('.nav-link').click(function() {
                var page = $(this).data('page'); // أخذ اسم الصفحة من الرابط
                $.get('user_links.php', {
                    page: page
                }, function(data) {
                    // تحديث المحتوى داخل العنصر #content
                    $('#content').html($(data).find('#content').html());
                    history.pushState(null, '', '?page=' + page); // تحديث الـ URL بدون إعادة تحميل الصفحة
                });
            });

            // تحميل المحتوى الأول عند تحميل الصفحة
            var initialPage = new URLSearchParams(window.location.search).get('page') || 'saved';
            $('.nav-link[data-page="' + initialPage + '"]').click(); // محاكاة الضغط على الرابط
        });
    </script>

</body>

</html>