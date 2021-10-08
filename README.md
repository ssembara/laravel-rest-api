# Laravel Rest Api
Created Rest API with Laravel 7. 
This project takes a book collection case study. 
The data needed is book and author data, 1 book has many authors, 1 author has many books

## Database Design
<div align='center'>

![typescript-rest-api](https://raw.githubusercontent.com/ssembara/laravel-rest-api/2-readme/Book%20ERD.jpg)

</div>

## Documentation
The Route User Management & Auth : 
| Method | EndPoint | Description |
| --- | --- | --- |
| POST | /api/auth/signup | User Register |
| POST | /api/auth/signin | User Auth |
| GET  | /api/auth/signout | User Log Out |
| GET  | /api/user/me     | User Profile |

The Route Author Management : 
| Method | EndPoint | Description |
| --- | --- | --- |
| GET | /api/authors | List |
| POST | /api/authors | Store |
| GET  | /api/authors/{author} | Show |
| PUT  | /api/authors/{author}     | Update |
| DELETE  | /api/authors/{author}     | Destroy |

The Route Book Management : 
| Method | EndPoint | Description |
| --- | --- | --- |
| GET | /api/books | List |
| POST | /api/books | Store |
| GET  | /api/books/{author} | Show |
| PUT  | /api/books/{author}     | Update |
| DELETE  | /api/books/{author}     | Destroy |

## Dependency
* [laravel/passport](https://laravel.com/docs/7.x/passport) &#8594; For OAuth based Token