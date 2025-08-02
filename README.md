<p>Для разворачивания приложения:</p>
<p>- клонировать репозиторий</p>
<p>- перейти в новую папку приложения</p>
<p>- скопировать файл настроек .env</p>
<p>- создать и запустить образы docker с файлом compose.dev.yaml</p>
<p>- установить необходимые зависимости для laravel, сгенерировать ключи и запустить миграции с заполенными данными</p>
<p>- статичный ключ для запросов API указывается в .env (API_KEY)</p>

<p>Инструкция для установки на Linux:</p>

<p><code>git clone https://github.com/Rintor/luna.git</code></p>
<p><code>cd luna</code></p>
<p><code>cp .env.example .env</code></p>
<p><code>docker compose -f compose.dev.yaml up -d</code></p>
<p><code>docker compose -f compose.dev.yaml exec workspace composer install</code></p>
<p><code>docker compose -f compose.dev.yaml exec workspace php artisan key:generate</code></p>
<p><code>docker compose -f compose.dev.yaml exec workspace php artisan migrate --seed</code></p>