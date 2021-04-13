<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Description
This Project is the First Laravel Project and The Target of this Project is to Try Php and Laravel to See how the Language and The Framework Looks Like when You Implement Logic and Database Connection, Response Mapper, Custom Database Query and Each Controller Implemented to be Based on Crud Implementation for Create , Update, Delete, Get and This project Designed to Be Always return Json Response Because UI Side Depends on Frontend Frameworks, Apps This is Just Server Side Logic

# Project Structure
1. Controllers is the Main Point For All Api's
2. Services is the Logic of Each End Point
3. Model is The Current Model Saved in Database
4. JWT In Login Request

# Controllers
1. Users Api
2. Shops Api
3. Items Api
4. User Address Api
5. Shop Branches Api
6. Items Comments Controller
7. Category Controller

# Api's Paths
1. POST : http://127.0.0.1:8000/api/v1/users
2. POST : http://127.0.0.1:8000/api/v1/users/login
3. POST : http://127.0.0.1:8000/api/v1/users/otp/refresh
4. POST : http://127.0.0.1:8000/api/v1/users/otp/verify
5. GET : http://127.0.0.1:8000/api/v1/users/reset/question
6. POST : http://127.0.0.1:8000/api/v1/users/reset/answer
7. GET : http://127.0.0.1:8000/api/v1/users
8. GET : http://127.0.0.1:8000/api/v1/users/1
9. GET : http://127.0.0.1:8000/api/v1/users/enabled
10. GET : http://127.0.0.1:8000/api/v1/users/disabled
11. DELETE : http://127.0.0.1:8000/api/v1/users
12. DELETE : http://127.0.0.1:8000/api/v1/users/1

13. POST : http://127.0.0.1:8000/api/v1/shops/users/addresses
14. GET : http://127.0.0.1:8000/api/v1/shops/users/addresses
15. GET : http://127.0.0.1:8000/api/v1/shops/users/addresses/1
16. GET : http://127.0.0.1:8000/api/v1/shops/users/addresses/enabled
17. GET : http://127.0.0.1:8000/api/v1/shops/users/addresses/disabled
18. DELETE : http://127.0.0.1:8000/api/v1/users/addresses/branches
19. DELETE : http://127.0.0.1:8000/api/v1/users/addresses/branches/1

20. POST : http://127.0.0.1:8000/api/v1/shops
21. GET : http://127.0.0.1:8000/api/v1/shops
22. GET : http://127.0.0.1:8000/api/v1/shops/1
23. GET : http://127.0.0.1:8000/api/v1/shops/1/items
24. GET : http://127.0.0.1:8000/api/v1/shops/1/items/all
25. GET : http://127.0.0.1:8000/api/v1/shops/1/menu
26. GET : http://127.0.0.1:8000/api/v1/shops/search
27. GET : http://127.0.0.1:8000/api/v1/shops/latest
28. GET : http://127.0.0.1:8000/api/v1/shops/enabled
29. GET : http://127.0.0.1:8000/api/v1/shops/disabled
30. DELETE : http://127.0.0.1:8000/api/v1/shops
31. DELETE : http://127.0.0.1:8000/api/v1/shops/1

32. POST : http://127.0.0.1:8000/api/v1/shops/branches
33. GET : http://127.0.0.1:8000/api/v1/shops/branches
34. GET : http://127.0.0.1:8000/api/v1/shops/branches/1
35. GET : http://127.0.0.1:8000/api/v1/shops/branches/enabled
36. GET : http://127.0.0.1:8000/api/v1/shops/branches/disabled
37. DELETE : http://127.0.0.1:8000/api/v1/shops/branches
38. DELETE : http://127.0.0.1:8000/api/v1/shops/branches/1

39. POST : http://127.0.0.1:8000/api/v1/categories
40. GET : http://127.0.0.1:8000/api/v1/categories
41. GET : http://127.0.0.1:8000/api/v1/categories/1
42. GET : http://127.0.0.1:8000/api/v1/categories/enabled
43. GET : http://127.0.0.1:8000/api/v1/categories/disabled
44. DELETE : http://127.0.0.1:8000/api/v1/categories
45. DELETE : http://127.0.0.1:8000/api/v1/categories/1

46. POST : http://127.0.0.1:8000/api/v1/items
47. POST : http://127.0.0.1:8000/api/v1/items/comments
48. GET : http://127.0.0.1:8000/api/v1/items/comments
49. GET : http://127.0.0.1:8000/api/v1/items/comments/1
50. GET : http://127.0.0.1:8000/api/v1/items/comments/all
51. GET : http://127.0.0.1:8000/api/v1/items
52. GET : http://127.0.0.1:8000/api/v1/items/search
53. GET : http://127.0.0.1:8000/api/v1/items/latest
54. GET : http://127.0.0.1:8000/api/v1/items/1
55. GET : http://127.0.0.1:8000/api/v1/items/enabled
56. GET : http://127.0.0.1:8000/api/v1/items/disabled
57. DELETE : http://127.0.0.1:8000/api/v1/items
58. DELETE : http://127.0.0.1:8000/api/v1/items/1

# Request Response Example
For Example When You Create User This is the Request Body
```
{
    "name": "Yazan Tarifi",
    "image": "https://uxwing.com/wp-content/themes/uxwing/download/12-people-gesture/user-profile.png",
    "password": "123456789",
    "email": "yazan98@gmail.com",
    "gender": "Male",
    "age": 15,
    "phone_number": "123456789",
    "location_lat": 15.2,
    "location_lng": 1548.2,
    "location_name": "Amman",
    "type": "Admin",
    "security_question": "asdfasdsdfsdf",
    "security_question_answer": "dsfsdfsefsedvsev"
}
```

### Success Response
```
{
    "code": 201,
    "message": "Data Found",
    "status": true,
    "path": "http://127.0.0.1:8000/api/v1/users",
    "timestamp": 1618272720,
    "data": {
        "name": "Yazan Tarifi",
        "image": "https://uxwing.com/wp-content/themes/uxwing/download/12-people-gesture/user-profile.png",
        "email": "ya15zan98@gmail.com",
        "gender": "Male",
        "age": 15,
        "phone_number": "12345671589",
        "location_lat": 15.2,
        "location_lng": 1548.2,
        "location_name": "Amman",
        "type": "Admin",
        "created_at": "2021-04-13 00:11:59",
        "is_enabled": 1,
        "is_account_activated": 0,
        "status": "NOT_VERIFIED",
        "id": 2,
        "is_account_enabled": 0
    }
}
```

### Error Response
```
{
    "code": 400,
    "message": "Failed",
    "status": false,
    "path": "http://127.0.0.1:8000/api/v1/users",
    "timestamp": 1618272664,
    "error": 0,
    "errorMessage": "Phone Number Already Used ...",
    "stackTrace": "#0 E:\\shop-api\\app\\Http\\Controllers\\UsersController.php(24): App\\Models\\Services\\UserService->saveEntity()\n#1 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\UsersController->saveEntity()\n#2 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(45): Illuminate\\Routing\\Controller->callAction()\n#3 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(254): Illuminate\\Routing\\ControllerDispatcher->dispatch()\n#4 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(197): Illuminate\\Routing\\Route->runController()\n#5 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(695): Illuminate\\Routing\\Route->run()\n#6 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php
```

# Login Example

### Success Response
```
{
    "code": 200,
    "message": "Data Found",
    "status": true,
    "path": "http://127.0.0.1:8000/api/v1/users/login",
    "timestamp": 1618272942,
    "data": {
        "user": {
            "name": "Yazan Tarifi",
            "image": "https://uxwing.com/wp-content/themes/uxwing/download/12-people-gesture/user-profile.png",
            "email": "yazan98@gmail.com",
            "gender": "Male",
            "age": 15,
            "phone_number": "123456789",
            "location_lat": 15.2,
            "location_lng": 1548.2,
            "location_name": "Amman",
            "type": "Admin",
            "created_at": "2021-04-10 16:38:42",
            "is_enabled": 1,
            "is_account_activated": 1,
            "status": "NOT_VERIFIED",
            "id": 7,
            "is_account_enabled": 1
        },
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC92MVwvdXNlcnNcL2xvZ2luIiwiaWF0IjoxNjE4MjcyOTQyLCJleHAiOjE2MTgyNzY1NDIsIm5iZiI6MTYxODI3Mjk0MiwianRpIjoiRzgzdjRhWVdlR3pRVFlGTCIsInN1YiI6NywicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.m2nUT8lCb-N8rH9hwYoL5LPBZEA50auP1LJDyDnQHlU",
        "tokenKey": "Bearer"
    }
}
```

### Error Response
```
{
    "code": 400,
    "message": "Failed",
    "status": false,
    "path": "http://127.0.0.1:8000/api/v1/users/login",
    "timestamp": 1618272893,
    "error": 0,
    "errorMessage": "Incorrect Email Or Password Please Try Again",
    "stackTrace": "#0 E:\\shop-api\\app\\Http\\Controllers\\UsersController.php(41): App\\Models\\Services\\UserService->loginAccount()\n#1 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\UsersController->loginAccount()\n#2 E:\\shop-api\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(45): Illuminate\\Routing\\Controller->callAction()\n#3 
```

# Development Commands
```
php artisan serve
php artisan migrate --force
php artisan migrate:refresh
php artisan make:migration create_shops_table
```


