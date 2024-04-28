```markdown
# Instrucciones de instalación para Metroglide Version Laravel 10

## Paso 1: Clonar el repositorio
```bash
git clone https://github.com/Trifunski/metroglide
```

## Paso 2: Cambiar al directorio del proyecto
```bash
cd metroglide_version_laravel_10
```

## Paso 3: Instalar las dependencias de PHP
```bash
composer install
```

## Paso 4: Copiar el archivo `.env.example` y renombrarlo a `.env`
```bash
cp .env.example .env
```

## Paso 5: Generar la clave de la aplicación
```bash
php artisan key:generate
```

## Paso 6: Instalar las dependencias de Node.js
```bash
npm install
```

## Paso 7: Compilar los recursos con Tailwind CSS
```bash
npm run dev
```

Sigue estos pasos para configurar el entorno de desarrollo local de Metroglide.
```