<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title inertia>{{ config('app.name') }} Office</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{
        Vite::useHotFile(storage_path('office.hot')) // Customize the "hot" file...
        ->useBuildDirectory('build/office') // Customize the build directory...
        ->useManifestFilename('assets.json') // Customize the manifest filename...
        ->withEntryPoints([ // Specify the entry points...
            'clients/office/main.ts',
            "clients/office/pages/{$page['component']}.vue"
        ]);
    }}
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
