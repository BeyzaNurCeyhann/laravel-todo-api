
# ✅ Laravel Todo API

Bu proje, Laravel 10 kullanılarak geliştirilmiş JWT tabanlı kimlik doğrulama ve rol bazlı yetkilendirmeye sahip bir Todo Yönetim API'sidir. Kategoriler ile ilişkilendirilmiş görevler üzerinde filtreleme, sıralama, sayfalama gibi işlemler yapılabilir. Ayrıca görev istatistikleri ve soft delete (yumuşak silme) desteği vardır.

---

## 📦 Kurulum ve Çalıştırma

1. **Proje dosyalarını klonla:**
```bash
git clone https://github.com/BeyzaNurCeyhann/laravel-todo-api.git
cd laravel-todo-api
```

2. **Bağımlılıkları yükle:**
```bash
composer install
```

3. **Ortam dosyasını oluştur:**
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

4. **Veritabanı yapılandır:**
```bash
php artisan migrate --seed
```

5. **Uygulamayı başlat:**
```bash
php artisan serve
```

---

## Authentication (JWT)

### Giriş (Login)
```http
POST /api/login
```
```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

Token'ı aldıktan sonra her istekte:
```http
Authorization: Bearer <TOKEN>
```

---

## Rol Bazlı Yetkilendirme (Authorization)

Uygulamada `admin` ve `user` rolleri vardır. Rollere göre izinler aşağıdaki gibidir:

| Endpoint                         | Erişim        |
|----------------------------------|----------------|
| `GET /api/categories`           | user + admin ✅ |
| `GET /api/categories/{id}`      | user + admin ✅ |
| `GET /api/categories/{id}/todos`| user + admin ✅ |
| `POST /api/categories`          | sadece admin 🔐 |
| `PUT /api/categories/{id}`      | sadece admin 🔐 |
| `DELETE /api/categories/{id}`   | sadece admin 🔐 |

UI tarafında sadece `admin` kullanıcılar Navbar’da "Kategoriler" linkini görebilir. Kullanıcı rolleri login sonrası `localStorage`'a kaydedilir:

```js
localStorage.setItem('user', JSON.stringify(response.data.data.user));
```

---

##  API Dökümantasyonu

### Görevler (Todos)

| Metod | Endpoint | Açıklama |
|-------|----------|----------|
| GET   | /api/todos | Görevleri listele (filtre, sıralama, sayfalama) |
| POST  | /api/todos | Yeni görev oluştur |
| PUT   | /api/todos/{id} | Görev güncelle |
| DELETE| /api/todos/{id} | Görev sil (soft delete) |
| GET   | /api/todos/search?term=... | Başlığa göre arama |
| GET   | /api/todos/stats | Durum ve öncelik bazlı istatistikler |

### Kategoriler (Categories)

| Metod | Endpoint | Açıklama |
|-------|----------|----------|
| GET   | /api/categories | Tüm kategorileri getir |
| POST  | /api/categories | Yeni kategori oluştur |
| PUT   | /api/categories/{id} | Kategori güncelle |
| DELETE| /api/categories/{id} | Kategori sil |

### İstatistikler (Stats)

| Metod | Endpoint | Açıklama |
|-------|----------|----------|
| GET   | /api/stats/todos | Tüm durumları sayılarıyla getir |
| POST  | /api/stats/priorities | Tüm öncelikleri sayılarıyla getir |


---

## Filtreleme & Sıralama & Sayfalama

- `page`, `limit`, `sort`, `order`, `status`, `priority` gibi query parametreleri desteklenir:
```http
GET /api/todos?page=1&limit=5&sort=due_date&order=desc&status=pending
```

---

## Test Kullanıcılar

| Rol | Email | Şifre |
|-----|-------|-------|
| Admin | admin@example.com | password |
| User  | user@example.com  | password |

---

##  Mimarî

- Laravel 10.x
- JWT Authentication
- Role-Based Authorization
- Service & Repository Pattern
- Exception Handling
- Eloquent ORM
- MySQL
- Custom JSON Response Format

---

## Test Verisi

`php artisan migrate --seed` komutu ile örnek kullanıcı ve todo verileri otomatik eklenir.

---

## Lisans

Bu proje eğitim amaçlı hazırlanmıştır.

