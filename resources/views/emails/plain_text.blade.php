<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار الرفض</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px;
        }
        .header .logo {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            background: url("http://127.0.0.1/storage/images/image.png ") no-repeat center center;
            background-size: contain;
            display: inline-block;
        }
        .content {
            margin-bottom: 20px;
        }
        .content p {
            line-height: 1.6;
        }
        .footer {
            background-color: #f4f4f4;
            color: #666;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            border-top: 1px solid #ccc;
        }
        .footer .logo {
            width: 50px;
            height: 50px;
            margin: 0 auto 10px auto;
            background: url("http://127.0.0.1/storage/images/image.png ") no-repeat center center;
            background-size: contain;
            display: inline-block;
        }
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo"></div>
            <h1>إشعار الرفض</h1>
        </div>
        <div class="content">
            <p>عزيزي/عزيزتي {{ $recipientName }},</p>
            <p>نأسف لإبلاغكم بأن طلبكم لإصدار باج السيارة للدخول إلى الجامعة قد تم مراجعته وللأسف، لا يمكننا المضي قدمًا في طلبكم في الوقت الحالي.</p>
            <p>نحن نقدر اهتمامكم بجامعة الموصل ونشجعكم على التقديم مرة أخرى في المستقبل.</p>
            <p>إذا كان لديكم أي استفسارات أو بحاجة إلى مزيد من المعلومات، يرجى عدم التردد في الاتصال بنا على [معلومات الاتصال].</p>
            <p>مع أطيب التحيات،</p>
            <p>شعبة المتابعة</p>
            <p>قسم إصدار الباجات</p>
            <p>جامعة الموصل</p>
        </div>
        <div class="footer">
            <div class="logo"></div>
            <p>فريق شعبة المتابعة - قسم إصدار الباجات</p>
            <p>جامعة الموصل</p>
            <p><a href="https://www.uomosul.edu.iq" target="_blank">www.uomosul.edu.iq</a></p>
        </div>
    </div>
</body>
</html>
