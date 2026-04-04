<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categories;
use App\Models\Complaints;
use App\Models\Contact;
use App\Models\News;
use App\Models\Settings;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function getSliders()
    {
        $sliders = Slider::where('is_active', 1)->lazy();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved sliders',
            'data' => $sliders
        ]);
    }

    // categories
    public function fetchCategories()
    {
        $categories = Categories::when(request('q'), function ($query, $q) {
            return $query->where('name', 'like', '%' . $q . '%');
        })
            ->lazy();

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved categories',
            'data' => $categories
        ]);
    }

    // categories by slug
    public function fetchNewsBySlugCategories($slug)
    {
        $news = News::with(['author:id,name', 'categories:id,name']) // Ganti ke 'categories'
            ->where('status', 'published')
            ->whereHas('categories', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->when(request('q'), function ($query, $q) {
                return $query->where('title', 'like', '%' . $q . '%')
                    ->orWhere('status', 'like', '%' . $q . '%');
            });

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved News by category: ' . $slug,
            'data' => $news->orderBy('published_at', 'desc')->get() // Gunakan get() jika datanya sedikit, atau paginate()
        ]);
    }

    public function fetchNews()
    {
        $news = News::with(['author:id,name', 'categories:id,name'])
            ->where('status', 'published')
            ->when(request('q'), function ($query, $searchTerm) {
                return $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('content', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $news->setCollection($news->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'content' => $item->content,
                'featured_image' => $item->featured_image ? asset('storage/' . $item->featured_image) : null,
                'published_at' => $item->published_at,
                'status' => $item->status,
                'author' => $item->author ? $item->author->name : null,
                'category' => $item->categories->first()?->name,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        }));

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved news',
            'data' => $news
        ]);
    }

    public function fetchNewsBySlug($slug)
    {
        $news = News::with(['author:id,name', 'categories:id,name', 'tags:id,name'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$news) {
            return response()->json([
                'status' => 404,
                'message' => 'News not found',
                'data' => null
            ], 404);
        }

        $imageFullUrl = $news->featured_image ? asset('storage/' . $news->featured_image) : null;

        $formattedData = [
            'title' => $news->title,
            'slug' => $news->slug,
            'excerpt' => $news->excerpt,
            'content' => $news->content,
            'featured_image' => $imageFullUrl,
            'published_at' => $news->published_at,
            'author' => $news->author?->name,
            'category' => $news->categories->first()?->name,
            'tags' => $news->tags->pluck('name'),
            'seo_meta' => [
                'title' => $news->title . ' - Nama Portal',
                'description' => Str::limit($news->getSeoMetaDescription(), 160),
                'image' => $imageFullUrl,
                'type' => $news->getSeoSchemaType(),
                'robots' => 'index, follow, max-image-preview:large',
                'keywords' => $news->tags->pluck('name')->push($news->title)->implode(', '),
                'json_ld' => [
                    '@context' => 'https://schema.org',
                    '@type' => 'NewsArticle',
                    'headline' => $news->title,
                    'image' => [$imageFullUrl],
                    'datePublished' => $news->published_at,
                    'author' => [['@type' => 'Person', 'name' => $news->author?->name]]
                ]
            ],

            'created_at' => $news->created_at,
            'updated_at' => $news->updated_at,
        ];

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved news detail',
            'data' => $formattedData
        ]);
    }
    public function fetchArticles()
    {
        $articles = Article::with(['author:id,name', 'categories:id,name'])
            ->where('status', 'published')
            ->when(request('q'), function ($query, $searchTerm) {
                return $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('content', 'like', '%' . $searchTerm . '%');
                });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $articles->setCollection($articles->getCollection()->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'excerpt' => $item->excerpt,
                'content' => $item->content,
                'featured_image' => $item->featured_image ? asset('storage/' . $item->featured_image) : null,
                'published_at' => $item->published_at,
                'status' => $item->status,
                'author' => $item->author ? $item->author->name : null,
                'category' => $item->categories->first()?->name,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        }));

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved articles',
            'data' => $articles
        ]);
    }

    public function fetchArticlesBySlug($slug)
    {
        $data = Article::with(['author:id,name', 'categories:id,name', 'tags:id,name'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$data) {
            return response()->json([
                'status' => 404,
                'message' => 'Article not found',
                'data' => null
            ], 404);
        }

        $imageFullUrl = $data->featured_image ? asset('storage/' . $data->featured_image) : null;

        $formattedData = [
            'title' => $data->title,
            'slug' => $data->slug,
            'excerpt' => $data->excerpt,
            'content' => $data->content,
            'featured_image' => $imageFullUrl,
            'published_at' => $data->published_at,
            'author' => $data->author?->name,
            'category' => $data->categories->first()?->name,
            'tags' => $data->tags->pluck('name'),
            'seo_meta' => [
                'title' => $data->title . ' - Nama Portal',
                'description' => Str::limit($data->getSeoMetaDescription(), 160),
                'image' => $imageFullUrl,
                'type' => $data->getSeoSchemaType(),
                'robots' => 'index, follow, max-image-preview:large',
                'keywords' => $data->tags->pluck('name')->push($data->title)->implode(', '),
                'json_ld' => [
                    '@context' => 'https://schema.org',
                    '@type' => $data->getSeoSchemaType(),
                    'headline' => $data->title,
                    'image' => [$imageFullUrl],
                    'datePublished' => $data->published_at,
                    'author' => [['@type' => 'Person', 'name' => $data->author?->name]]
                ]
            ],

            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        ];

        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved article detail',
            'data' => $formattedData
        ]);
    }

    public function fetchComplaints()
    {
        $complaints = Complaints::with('complaintLinks:id,complaint_id,title,url')
            ->orderBy('created_at', 'desc')->lazy();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved complaints',
            'data' => $complaints
        ]);
    }

    public function fetchSettings()
    {
        $settings = Settings::first();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully retrieved settings',
            'data' => $settings
        ]);
    }

    public function submitContactForm(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            Contact::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'message' => $data['message'],
            ]);

            return response()->json([
                'status' => 201,
                'message' => 'Contact form submitted successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to submit contact form: ' . $e->getMessage(),
            ], 500);
        }
    }
}
