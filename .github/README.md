# GitHub Actions Deploy

Thư mục này chứa cấu hình CI/CD cho GitHub Actions.

## Workflow deploy master

File workflow: `.github/workflows/deploy-master.yml`

Workflow sẽ chạy khi có push lên nhánh `master`.

## GitHub Secrets cần cấu hình

Vào GitHub repository:

`Settings` > `Secrets and variables` > `Actions` > `New repository secret`

Thêm các secret sau:

| Secret | Mô tả |
| --- | --- |
| `MASTER_SSH_HOST` | Hostname hoặc IP server deploy cho nhánh `master` |
| `MASTER_SSH_USER` | SSH user dùng để đăng nhập server |
| `MASTER_SSH_PORT` | SSH port, thường là `22` |
| `MASTER_SSH_PRIVATE_KEY` | Private key SSH dùng để deploy |
| `MASTER_SERVER_PROJECT_PATH` | Đường dẫn source Laravel trên server |
| `MASTER_SERVER_PUBLIC_PATH` | Đường dẫn public web root trên server |

## Yêu cầu trên server

Server cần có sẵn:

- Git
- PHP đúng version của project
- Composer
- rsync
- Quyền SSH user đủ để đọc/ghi vào `MASTER_SERVER_PROJECT_PATH`
- Quyền SSH user đủ để đọc/ghi vào `MASTER_SERVER_PUBLIC_PATH`

Source Laravel trên server cần được clone sẵn và remote `origin` trỏ về đúng repository GitHub.

## Lệnh deploy sẽ chạy

Workflow đăng nhập vào server bằng SSH, sau đó chạy:

```bash
cd "$MASTER_SERVER_PROJECT_PATH"
git pull --ff-only origin master
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
php artisan down
php artisan migrate --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
rsync -a --delete --exclude='index.php' --exclude='storage' public/ "$MASTER_SERVER_PUBLIC_PATH"/
php artisan up
```

## Ghi chú public path

Lệnh copy public sẽ đồng bộ toàn bộ nội dung trong `public/` sang `MASTER_SERVER_PUBLIC_PATH`, nhưng sẽ bỏ qua:

- `public/index.php`
- `public/storage`

Vì vậy file `index.php` và symlink/folder `storage` tại web root của server sẽ không bị ghi đè.

