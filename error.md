# Illuminate\Foundation\ViteManifestNotFoundException - Internal Server Error

Vite manifest not found at: E:\ecommerce\public\build/manifest.json

PHP 8.5.1
Laravel 13.5.0
localhost:8000

## Stack Trace

0 - vendor\laravel\framework\src\Illuminate\Foundation\Vite.php:946
1 - vendor\laravel\framework\src\Illuminate\Foundation\Vite.php:384
2 - resources\views\layouts\app.blade.php:15
3 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:123
4 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:124
5 - vendor\laravel\framework\src\Illuminate\View\Engines\PhpEngine.php:57
6 - vendor\laravel\framework\src\Illuminate\View\Engines\CompilerEngine.php:76
7 - vendor\laravel\framework\src\Illuminate\View\View.php:208
8 - vendor\laravel\framework\src\Illuminate\View\View.php:191
9 - vendor\laravel\framework\src\Illuminate\View\View.php:160
10 - vendor\laravel\framework\src\Illuminate\View\Concerns\ManagesComponents.php:99
11 - resources\views\profile\edit.blade.php:24
12 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:123
13 - vendor\laravel\framework\src\Illuminate\Filesystem\Filesystem.php:124
14 - vendor\laravel\framework\src\Illuminate\View\Engines\PhpEngine.php:57
15 - vendor\laravel\framework\src\Illuminate\View\Engines\CompilerEngine.php:76
16 - vendor\laravel\framework\src\Illuminate\View\View.php:208
17 - vendor\laravel\framework\src\Illuminate\View\View.php:191
18 - vendor\laravel\framework\src\Illuminate\View\View.php:160
19 - vendor\laravel\framework\src\Illuminate\Http\Response.php:78
20 - vendor\laravel\framework\src\Illuminate\Http\Response.php:34
21 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:939
22 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:906
23 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
24 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
25 - vendor\laravel\framework\src\Illuminate\Routing\Middleware\SubstituteBindings.php:52
26 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
27 - vendor\laravel\framework\src\Illuminate\Auth\Middleware\Authenticate.php:63
28 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
29 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\PreventRequestForgery.php:104
30 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
31 - vendor\laravel\framework\src\Illuminate\View\Middleware\ShareErrorsFromSession.php:48
32 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
33 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:120
34 - vendor\laravel\framework\src\Illuminate\Session\Middleware\StartSession.php:63
35 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
36 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse.php:36
37 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
38 - vendor\laravel\framework\src\Illuminate\Cookie\Middleware\EncryptCookies.php:74
39 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
40 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
41 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:821
42 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:800
43 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:764
44 - vendor\laravel\framework\src\Illuminate\Routing\Router.php:753
45 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:200
46 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:180
47 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
48 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull.php:31
49 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
50 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TransformsRequest.php:21
51 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\TrimStrings.php:51
52 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
53 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePostSize.php:27
54 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
55 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance.php:109
56 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
57 - vendor\laravel\framework\src\Illuminate\Http\Middleware\HandleCors.php:61
58 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
59 - vendor\laravel\framework\src\Illuminate\Http\Middleware\TrustProxies.php:58
60 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
61 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks.php:22
62 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
63 - vendor\laravel\framework\src\Illuminate\Http\Middleware\ValidatePathEncoding.php:28
64 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:219
65 - vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php:137
66 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:175
67 - vendor\laravel\framework\src\Illuminate\Foundation\Http\Kernel.php:144
68 - vendor\laravel\framework\src\Illuminate\Foundation\Application.php:1220
69 - public\index.php:20
70 - vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php:23


## Request

GET /profile

## Headers

* **host**: localhost:8000
* **connection**: keep-alive
* **sec-ch-ua**: "Brave";v="147", "Not.A/Brand";v="8", "Chromium";v="147"
* **sec-ch-ua-mobile**: ?0
* **sec-ch-ua-platform**: "Windows"
* **upgrade-insecure-requests**: 1
* **user-agent**: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36
* **accept**: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8
* **sec-gpc**: 1
* **accept-language**: id;q=0.7
* **sec-fetch-site**: same-origin
* **sec-fetch-mode**: navigate
* **sec-fetch-user**: ?1
* **sec-fetch-dest**: document
* **referer**: http://localhost:8000/wishlist
* **accept-encoding**: gzip, deflate, br, zstd
* **cookie**: wf_session=cart_20a79bfc02b044caa41d4c7dacc6b756.f72335d7efcb5caf6144547bd573199cde2470d52ba1b684d9a8c9c1567b0837; wf_session_auth=sess_00a9952e31cf4cb3b48333c8cc620fdf.d291a48cd616cc57efc178cfbe17259d35ef26d113ffcc0b978f16b5d0d2557b; next-auth.csrf-token=8c2f266ff0367a639d62f1b23c78f4381398f2011ce9b685e70644ad268237ac%7C2d3973d166d8eaa2b53a0815b63aa5e9e9835adffd06751c20e5190addf5bd1d; next-auth.callback-url=http%3A%2F%2Flocalhost%3A3000; next-auth.session-token=eyJhbGciOiJkaXIiLCJlbmMiOiJBMjU2R0NNIn0..7JR3kRLo3RoL7vzs.wtl0tX1NYMz4sNNR2PwyfGUELcGC5P0ddy08hyhSOJJCIg9tiraE-rty71LCPT9AExJfYwyFzkxN8SMj_gG7Ahr-4wxoholLLGoLtAYwFur2zl-dcuLNX_vy-ku81ofYPrMIipBaGYZjT9V1NJk6AITmfvftz4nrXVNIxPlExSAxZTlKX1b42K2HWFRnx50o445WYic6cNLPqPXfxcEiXYCrAI20Imh4.TD2292V-WeGrsAskioxIYg; XSRF-TOKEN=eyJpdiI6IkxaQmVJVzVSWmVVT2FhNWtPWG5zdFE9PSIsInZhbHVlIjoicWtxZGJQZ3hOeWozcmx5VlV3WWEvZzA3NU9KT2V0RTZYUk9udHBMTnJVd3JJN0lZYzExMVhORVRoaElMLzdQQVBjUFpTZlFlL1oxei8yM0djdXp1VUw5WVA4MDdiWXFJTU53eHpodnpjMVVEczBPRkhTSDBKNW5XT2U1OHdFWGYiLCJtYWMiOiIxYTRiNWYyYmIzMTRkYjA4YzE0OTZmYjlkM2I0Y2Y3NmJjNzJjMzM3YjQ5NDQ4MmI4ZDQwMDJhMWE4Njc1ZGY3IiwidGFnIjoiIn0%3D; laravel-session=eyJpdiI6IlEweHRvdXd6dm5XWC82TFQySldkZnc9PSIsInZhbHVlIjoiYzhYUHgxNXptRXFZekRBL3BUZGtLR0R2QVFVbmR4akJBZTVRYXd0MWtoMVNXczMrWTBzZUdzYnowTXFMSG9wUWtKT1FEckVKZkpRQTd5Y1Y5WDJEbUppa1cwS0QrMC9KY1ludVNWMEF2eDI5NHdOOXJ2ZU1sL3Y1WkltWjJPaVYiLCJtYWMiOiI0MTBhMzg0MTgzYTEwZjc0MjcyOTBjNGMwYjlkMGUxYTcyNGRhYjE3ZDg4YzQ1NzI2MDE1OWJhYjU1YzU3NjZmIiwidGFnIjoiIn0%3D

## Route Context

controller: App\Http\Controllers\ProfileController@edit
route name: profile.edit
middleware: web, auth

## Route Parameters

No route parameter data available.

## Database Queries

* sqlite - select * from "sessions" where "id" = 'uEiXOL0qJq9X9ukYEJfYmr9hoRT3PN8TFO1Oo2v8' limit 1 (1.19 ms)
* sqlite - select * from "users" where "id" = 2 limit 1 (0.19 ms)
