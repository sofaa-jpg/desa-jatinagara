#!/bin/bash

echo "🚀 Starting Azure App Service for Laravel..."

# Copy nginx configuration
echo "📋 Copying nginx configuration..."
cp /home/site/wwwroot/default /etc/nginx/sites-available/default

# Set proper permissions
echo "🔐 Setting permissions..."
chmod 755 /home/site/wwwroot/storage/app/public
chmod 755 /home/site/wwwroot/storage/framework/views
chmod 755 /home/site/wwwroot/storage/logs

# Create required directories if not exist
echo "📁 Creating directories..."
mkdir -p /home/site/wwwroot/storage/framework/cache
mkdir -p /home/site/wwwroot/storage/framework/sessions
mkdir -p /home/site/wwwroot/storage/framework/views
mkdir -p /home/site/wwwroot/storage/app/public/gallery_images

# Test nginx configuration
echo "🧪 Testing nginx configuration..."
nginx -t

if [ $? -eq 0 ]; then
    echo "✅ Nginx configuration is valid"
    
    # Reload nginx
    echo "🔄 Reloading nginx..."
    service nginx reload
    
    echo "✅ Nginx reloaded successfully"
else
    echo "❌ Nginx configuration has errors!"
    exit 1
fi

# Show current PHP settings
echo "📊 Current PHP upload settings:"
php -r "echo 'upload_max_filesize: ' . ini_get('upload_max_filesize') . PHP_EOL;"
php -r "echo 'post_max_size: ' . ini_get('post_max_size') . PHP_EOL;"
php -r "echo 'max_file_uploads: ' . ini_get('max_file_uploads') . PHP_EOL;"

echo "🎉 Startup completed successfully!"