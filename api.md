# API Documentation

## Base URL

```
http://localhost:8000/api
```

## Authentication Headers (Wajib)

Semua endpoint memerlukan header berikut:

| Header | Value |
|--------|-------|
| `X-Internal-Key` | `123123nadasdakqw21314004324` |
| `X-APP-Key` | `123123nadasdakqw21314004325` |

---

## Endpoints

### 1. Settings

#### `GET /settings`

Mengambil konfigurasi website.

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved settings",
    "data": {
        "id": 1,
        "logo": "settings/01KN8MV12CSSN07WHWHJGRWDF7.png",
        "site_name": "Portal Papua",
        "description": "<p>Portal resmi informasi dan layanan publik...</p>",
        "welcome_text": "Selamat Datang di Portal Resmi Pemerintah Provinsi Papua",
        "visi": "<p>Mewujudkan Papua yang mandiri...</p>",
        "misi": "<p><ol><li>Meningkatkan kualitas SDM...</li></ol></p>",
        "name_gubernur": "Lukas Enembe",
        "position_gubernur": "Gubernur Papua",
        "photo_gubernur": "settings/photo.jpeg",
        "name_wakil_gubernur": "John Wempi Wetipo",
        "position_wakil_gubernur": "Wakil Gubernur Papua",
        "photo_wakil_gubernur": "settings/photo2.jpeg",
        "address": "Jln. Soa Siu Dok 2 Bawah, Jayapura, Papua",
        "phone": "+6281239005482",
        "email": "info@papua.go.id",
        "created_at": "2026-04-03T03:02:17.000000Z",
        "updated_at": "2026-04-03T03:05:28.000000Z"
    }
}
```

---

### 2. Sliders

#### `GET /sliders`

Mengambil daftar slider yang aktif.

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved sliders",
    "data": [
        {
            "id": 1,
            "title": "Selamat Datang di Papua",
            "description": "Portal resmi Pemerintah Provinsi Papua",
            "image": "sliders/image.webp",
            "is_active": 1,
            "created_at": "2026-04-03T03:00:00.000000Z",
            "updated_at": "2026-04-03T03:00:00.000000Z"
        }
    ]
}
```

---

### 3. Categories

#### `GET /categories`

Mengambil daftar kategori.

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `q` | string | (optional) Filter berdasarkan nama |

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved categories",
    "data": [
        {
            "id": 1,
            "name": "Pemerintahan",
            "slug": "pemerintahan",
            "created_at": "2026-04-03T03:15:16.000000Z",
            "updated_at": "2026-04-03T03:15:16.000000Z"
        }
    ]
}
```

#### `GET /category/{slug}`

Mengambil berita berdasarkan slug kategori.

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved News by category: pemerintahan",
    "data": [
        {
            "id": 1,
            "category_id": 1,
            "title": "Judul Berita",
            "slug": "judul-berita",
            "excerpt": "Ringkasan berita...",
            "content": "<p>Isi berita lengkap.</p>",
            "featured_image": "news/image.webp",
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
                    "name": "Pemerintahan"
                }
            ]
        }
    ]
}
```

---

### 4. News

#### `GET /news`

Mengambil daftar berita (paginated, 10 per halaman).

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `q` | string | (optional) Pencarian berdasarkan judul/konten |
| `page` | int | (optional) Nomor halaman |

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved news",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "Judul Berita",
                "slug": "judul-berita",
                "excerpt": "Ringkasan berita...",
                "content": "<p>Isi berita.</p>",
                "featured_image": "http://localhost:8000/storage/news/image.webp",
                "published_at": "2026-04-03 03:15:58",
                "status": "published",
                "author": "CMS Papua",
                "category": "Pemerintahan",
                "created_at": "2026-04-03T03:15:58.000000Z",
                "updated_at": "2026-04-03T03:15:59.000000Z"
            }
        ],
        "first_page_url": "http://localhost:8000/api/news?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/news?page=1",
        "next_page_url": null,
        "per_page": 10,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    }
}
```

#### `GET /news/{slug}`

Mengambil detail berita berdasarkan slug (termasuk SEO metadata).

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved news detail",
    "data": {
        "title": "Judul Berita",
        "slug": "judul-berita",
        "excerpt": "Ringkasan berita...",
        "content": "<p>Isi berita lengkap.</p>",
        "featured_image": "http://localhost:8000/storage/news/image.webp",
        "published_at": "2026-04-03 03:15:58",
        "author": "CMS Papua",
        "category": "Pemerintahan",
        "tags": ["tag1", "tag2"],
        "seo_meta": {
            "title": "Judul Berita - Nama Portal",
            "description": "Ringkasan berita...",
            "image": "http://localhost:8000/storage/news/image.webp",
            "type": "News",
            "robots": "index, follow, max-image-preview:large",
            "keywords": "tag1, tag2, Judul Berita",
            "json_ld": {
                "@context": "https://schema.org",
                "@type": "NewsArticle",
                "headline": "Judul Berita",
                "image": ["http://localhost:8000/storage/news/image.webp"],
                "datePublished": "2026-04-03 03:15:58",
                "author": [{"@type": "Person", "name": "CMS Papua"}]
            }
        },
        "created_at": "2026-04-03T03:15:58.000000Z",
        "updated_at": "2026-04-03T03:15:59.000000Z"
    }
}
```

---

### 5. Articles

#### `GET /articles`

Mengambil daftar artikel (paginated, 10 per halaman).

**Query Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `q` | string | (optional) Pencarian berdasarkan judul/konten |
| `page` | int | (optional) Nomor halaman |

**Response:** Sama seperti `/news` dengan tipe data artikel.

#### `GET /articles/{slug}`

Mengambil detail artikel berdasarkan slug (termasuk SEO metadata).

**Response:** Sama seperti `/news/{slug}` dengan `@type: "Article"`.

---

### 6. Complaints

#### `GET /complaints`

Mengambil daftar pengaduan beserta link terkait.

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved complaints",
    "data": [
        {
            "id": 1,
            "title": "Layanan Pengaduan Masyarakat",
            "description": "Sampaikan pengaduan Anda terkait pelayanan publik...",
            "created_at": "2026-04-03T13:42:40.000000Z",
            "updated_at": "2026-04-03T13:42:40.000000Z",
            "complaint_links": [
                {
                    "id": 1,
                    "complaint_id": 1,
                    "title": "LAPOR!",
                    "url": "https://www.lapor.go.id/"
                }
            ]
        }
    ]
}
```

---

### 7. Tourism

#### `GET /tourisms`

Mengambil daftar destinasi wisata.

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved tourisms",
    "data": [
        {
            "id": 1,
            "name": "Raja Ampat",
            "slug": "raja-ampat",
            "location": "Kabupaten Raja Ampat",
            "description": "Kepulauan dengan keindahan bawah laut kelas dunia...",
            "image": "http://localhost:8000/storage/tourism/image.webp",
            "category": "Wisata Alam",
            "created_at": "2026-05-13T00:00:00.000000Z",
            "updated_at": "2026-05-13T00:00:00.000000Z"
        }
    ]
}
```

#### `GET /tourisms/{slug}`

Mengambil detail wisata berdasarkan slug.

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved tourism detail",
    "data": {
        "id": 1,
        "name": "Raja Ampat",
        "slug": "raja-ampat",
        "location": "Kabupaten Raja Ampat",
        "description": "Kepulauan dengan keindahan bawah laut kelas dunia...",
        "image": "http://localhost:8000/storage/tourism/image.webp",
        "category": "Wisata Alam",
        "created_at": "2026-05-13T00:00:00.000000Z",
        "updated_at": "2026-05-13T00:00:00.000000Z"
    }
}
```

---

### 8. Application Services

#### `GET /application-services`

Mengambil daftar layanan aplikasi.

**Response:**

```json
{
    "status": 200,
    "message": "Successfully retrieved application services",
    "data": [
        {
            "id": 1,
            "title": "SIPD - Sistem Informasi Pemerintahan Daerah",
            "description": "Sistem informasi untuk pengelolaan data pemerintahan daerah.",
            "url": "https://sipd.papua.go.id",
            "created_at": "2026-05-13T00:00:00.000000Z",
            "updated_at": "2026-05-13T00:00:00.000000Z"
        }
    ]
}
```

---

### 9. Contact

#### `POST /contact`

Mengirim pesan kontak.

**Request Body:**

```json
{
    "name": "Nama Pengirim",
    "email": "email@example.com",
    "phone_number": "081234567890",
    "message": "Isi pesan..."
}
```

**Validation:**

| Field | Rules |
|-------|-------|
| `name` | required, string, max:255 |
| `email` | required, email, max:255 |
| `phone_number` | nullable, string, max:20 |
| `message` | required, string |

**Response (Success):**

```json
{
    "status": 201,
    "message": "Contact form submitted successfully"
}
```

**Response (Error):**

```json
{
    "status": 500,
    "message": "Failed to submit contact form: ..."
}
```

---

## Error Responses

### 404 Not Found

```json
{
    "status": 404,
    "message": "News not found",
    "data": null
}
```

### 422 Validation Error

```json
{
    "message": "The name field is required.",
    "errors": {
        "name": ["The name field is required."]
    }
}
```
