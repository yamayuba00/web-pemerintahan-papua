# Fetching API

## How To Fetch API:

### Fetch Setting: [GET]
    End: http://localhost:8000/api/settings 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325

    {
        "status": 200,
        "message": "Successfully retrieved settings",
        "data": {
            "id": 1,
            "logo": "settings/01KN8MV12CSSN07WHWHJGRWDF7.png",
            "site_name": "CMS Papua",
            "description": "<p>CMS Papua</p>",
            "visi": "<p>CMS Papua</p>",
            "misi": "<p>CMS Papua</p>",
            "name_gubernur": "CMS Papua",
            "position_gubernur": "CMS Papua",
            "photo_gubernur": "settings/01KN8MV1CJSR78HE2C0SPRFZ74.jpeg",
            "name_wakil_gubernur": "CMS Papua",
            "position_wakil_gubernur": "CMS Papua",
            "photo_wakil_gubernur": "settings/01KN8MV1CWP4YEB81RF93AJ2GN.jpeg",
            "welcome_text": "Text",
            "created_at": "2026-04-03T03:02:17.000000Z",
            "updated_at": "2026-04-03T03:05:28.000000Z",
            "address": "Jln. Soa Siu Dok 2 Bawah Jayapura Papua",
            "phone": "+6281239005482",
            "email": "cms@papua.go.id"
        }
    }

### Fetch Categories: [GET]
    End: http://localhost:8000/api/categories?q= 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325

    {
    "status": 200,
    "message": "Successfully retrieved categories",
    "data": [
            {
            "id": 1,
            "name": "Test",
            "slug": "test",
            "created_at": "2026-04-03T03:15:16.000000Z",
            "updated_at": "2026-04-03T03:15:16.000000Z"
            }
        ]
    }

### Fetch Categories By Slug: [GET]
    End: http://localhost:8000/api/category/{slug} 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325

    {
        "status": 200,
        "message": "Successfully retrieved News by category: test",
        "data": [
            {
            "id": 1,
            "category_id": 1,
            "title": "Eveniet doloremque ",
            "slug": "eveniet-doloremque",
            "excerpt": "Sit velit mollit do",
            "content": "<p>Occaecat aut nostrum.</p>",
            "featured_image": "news/01KN8NE91QX6S8CAPG5ZGNC897-1775186159.webp",
            "published_at": "2026-04-03 03:15:58",
            "status": "published",
            "created_by": 1,
            "created_at": "2026-04-03T03:15:58.000000Z",
            "updated_at": "2026-04-03T03:15:59.000000Z",
            "author": {
                "id": 1,
                "name": "CMS Papua"
            },
            "categories": [
                {
                "id": 1,
                "name": "Test",
                "pivot": {
                    "categoryable_type": "App\\Models\\News",
                    "categoryable_id": 1,
                    "category_id": 1
                }
                }
            ]
            }
        ]
    }

### Fetch News: [GET]
    End: http://localhost:8000/api/news 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325

    {
        "status": 200,
        "message": "Successfully retrieved news",
        "data": {
            "current_page": 1,
            "data": [
            {
                "id": 1,
                "title": "Eveniet doloremque ",
                "slug": "eveniet-doloremque",
                "excerpt": "Sit velit mollit do",
                "content": "<p>Occaecat aut nostrum.</p>",
                "featured_image": "http://localhost:8000/storage/news/01KN8NE91QX6S8CAPG5ZGNC897-1775186159.webp",
                "published_at": "2026-04-03 03:15:58",
                "status": "published",
                "author": "CMS Papua",
                "category": "Test",
                "created_at": "2026-04-03T03:15:58.000000Z",
                "updated_at": "2026-04-03T03:15:59.000000Z"
            }
            ],
            "first_page_url": "http://localhost:8000/api/news?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost:8000/api/news?page=1",
            "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://localhost:8000/api/news?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
            ],
            "next_page_url": null,
            "path": "http://localhost:8000/api/news",
            "per_page": 10,
            "prev_page_url": null,
            "to": 1,
            "total": 1
        }
    }
### Fetch News By Slug: [GET]
    End: http://localhost:8000/api/news/{slug} 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325

    {
        "status": 200,
        "message": "Successfully retrieved news detail",
        "data": {
            "title": "Eveniet doloremque ",
            "slug": "eveniet-doloremque",
            "excerpt": "Sit velit mollit do",
            "content": "<p>Occaecat aut nostrum.</p>",
            "featured_image": "http://localhost:8000/storage/news/01KN8NE91QX6S8CAPG5ZGNC897-1775186159.webp",
            "published_at": "2026-04-03 03:15:58",
            "author": "CMS Papua",
            "category": "Test",
            "tags": [
            "accusamus facilis et"
            ],
            "seo_meta": {
            "title": "Eveniet doloremque  - Nama Portal",
            "description": "Occaecat aut nostrum.",
            "image": "http://localhost:8000/storage/news/01KN8NE91QX6S8CAPG5ZGNC897-1775186159.webp",
            "type": "News",
            "robots": "index, follow, max-image-preview:large",
            "keywords": "accusamus facilis et, Eveniet doloremque ",
            "json_ld": {
                "@context": "https://schema.org",
                "@type": "NewsArticle",
                "headline": "Eveniet doloremque ",
                "image": [
                "http://localhost:8000/storage/news/01KN8NE91QX6S8CAPG5ZGNC897-1775186159.webp"
                ],
                "datePublished": "2026-04-03 03:15:58",
                "author": [
                {
                    "@type": "Person",
                    "name": "CMS Papua"
                }
                ]
            }
            },
            "created_at": "2026-04-03T03:15:58.000000Z",
            "updated_at": "2026-04-03T03:15:59.000000Z"
        }
    }

### Fetch Articles: [GET]
    End: http://localhost:8000/api/articles 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325

    {
        "status": 200,
        "message": "Successfully retrieved articles",
        "data": {
            "current_page": 1,
            "data": [
            {
                "id": 1,
                "title": "Velit itaque nostrud",
                "slug": "velit-itaque-nostrud",
                "excerpt": "Incididunt exercitat",
                "content": "<p>Dolor accusamus face.</p>",
                "featured_image": "http://localhost:8000/storage/articles/01KN8NMN11FT0P4YF52A7AN4DD-1775186367.webp",
                "published_at": "2026-04-03 03:19:27",
                "status": "published",
                "author": "CMS Papua",
                "category": "Test",
                "created_at": "2026-04-03T03:19:27.000000Z",
                "updated_at": "2026-04-03T03:19:27.000000Z"
            }
            ],
            "first_page_url": "http://localhost:8000/api/articles?page=1",
            "from": 1,
            "last_page": 1,
            "last_page_url": "http://localhost:8000/api/articles?page=1",
            "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://localhost:8000/api/articles?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
            ],
            "next_page_url": null,
            "path": "http://localhost:8000/api/articles",
            "per_page": 10,
            "prev_page_url": null,
            "to": 1,
            "total": 1
        }
    }

### Fetch Articles By Slug: [GET]
    End: http://localhost:8000/api/articles/{slug} 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325

    {
        "status": 200,
        "message": "Successfully retrieved article detail",
        "data": {
            "title": "Velit itaque nostrud",
            "slug": "velit-itaque-nostrud",
            "excerpt": "Incididunt exercitat",
            "content": "<p>Dolor accusamus face.</p>",
            "featured_image": "http://localhost:8000/storage/articles/01KN8NMN11FT0P4YF52A7AN4DD-1775186367.webp",
            "published_at": "2026-04-03 03:19:27",
            "author": "CMS Papua",
            "category": "Test",
            "tags": [
            "tenetur non quaerat"
            ],
            "seo_meta": {
            "title": "Velit itaque nostrud - Nama Portal",
            "description": "Dolor accusamus face.",
            "image": "http://localhost:8000/storage/articles/01KN8NMN11FT0P4YF52A7AN4DD-1775186367.webp",
            "type": "Article",
            "robots": "index, follow, max-image-preview:large",
            "keywords": "tenetur non quaerat, Velit itaque nostrud",
            "json_ld": {
                "@context": "https://schema.org",
                "@type": "Article",
                "headline": "Velit itaque nostrud",
                "image": [
                "http://localhost:8000/storage/articles/01KN8NMN11FT0P4YF52A7AN4DD-1775186367.webp"
                ],
                "datePublished": "2026-04-03 03:19:27",
                "author": [
                {
                    "@type": "Person",
                    "name": "CMS Papua"
                }
                ]
            }
            },
            "created_at": "2026-04-03T03:19:27.000000Z",
            "updated_at": "2026-04-03T03:19:27.000000Z"
        }
    }

### Post Contact Message: [POST]
    End: http://localhost:8000/api/contact 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325
    Raw Body:
        {
            "name": "Test",
            "email": "test@gmail.com",
            "message": "Testings.."
        }

### Complaints [GET]
    End:http://localhost:8000/api/complaints 
    Set Header (Wajib):
        X-Internal-Key: 123123nadasdakqw21314004324
        X-APP-Key: 123123nadasdakqw21314004325
    Raw Body:
    {
        "status": 200,
        "message": "Successfully retrieved complaints",
        "data": [
            {
                "id": 1,
                "title": "Test",
                "description": "Eager Loading Tags: Dengan menambahkan tags:id,name di fungsi with(), kamu menghemat satu query database. Bayangkan jika ada 1000 user yang akses berita secara bersamaan, ini sangat menolong beban server",
                "created_at": "2026-04-03T13:42:40.000000Z",
                "updated_at": "2026-04-03T13:42:40.000000Z",
                "complaint_links": [
                    {
                        "id": 1,
                        "complaint_id": 1,
                        "title": "Service A",
                        "url": "http://localhost:8000/"
                    },
                    {
                        "id": 2,
                        "complaint_id": 1,
                        "title": "Service B",
                        "url": "http://localhost:8000/"
                    }
                ]
            }
        ]
    }