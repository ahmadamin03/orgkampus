<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation | OrgKampus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.17.14/swagger-ui.min.css">
    <style>
        body { margin: 0; background: #141417; }
        .swagger-ui .topbar { display: none; }
        .swagger-ui .info .title { color: #f97316 !important; }
        .swagger-ui .info { margin: 20px 0; }
        .swagger-ui .scheme-container { background: #1e1e24; box-shadow: none; }
        .swagger-ui { color: #e4e4e7; }
        .swagger-ui .opblock-tag { color: #f97316; }
        .swagger-ui .opblock .opblock-summary-description { color: #a1a1aa; }
        .swagger-ui .opblock .opblock-summary-operation { color: #e4e4e7; }
        .swagger-ui .opblock-body pre { background: #09090b; }
        .swagger-ui .response-col_status { color: #a1a1aa; }
        .swagger-ui .response-col_links { color: #a1a1aa; }
        .swagger-ui table thead tr td, .swagger-ui table thead tr th { color: #e4e4e7; border-bottom: 1px solid #2a2a30; }
        .swagger-ui .parameter__name { color: #e4e4e7; }
        .swagger-ui .parameter__type { color: #a1a1aa; }
        .swagger-ui .opblock-description-wrapper p { color: #a1a1aa; }
        .swagger-ui .opblock .opblock-summary-description { color: #a1a1aa; }
        .swagger-ui .btn { color: #e4e4e7; }
        .swagger-ui select { background: #09090b; color: #e4e4e7; border-color: #2a2a30; }
        .swagger-ui .opblock-body select { background: #09090b; color: #e4e4e7; border-color: #2a2a30; }
        .swagger-ui input[type=text] { background: #09090b; color: #e4e4e7; border-color: #2a2a30; }
        .swagger-ui textarea { background: #09090b; color: #e4e4e7; border-color: #2a2a30; }
        .swagger-ui .opblock { background: #141417; border-color: #2a2a30; }
        .swagger-ui .opblock .opblock-section-header { background: #1e1e24; }
        .swagger-ui .opblock .opblock-section-header h4 { color: #e4e4e7; }
        .swagger-ui .model-box { background: #09090b; }
        .swagger-ui .model { color: #e4e4e7; }
        .swagger-ui .model-title { color: #e4e4e7; }
        .swagger-ui .prop-type { color: #f97316; }
        .swagger-ui .property-row td:first-child { color: #e4e4e7; }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/5.17.14/swagger-ui-bundle.min.js"></script>
    <script>
        SwaggerUIBundle({
            url: '{{ $specPath }}',
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIBundle.SwaggerUIStandalonePreset,
            ],
            layout: "BaseLayout",
        });
    </script>
</body>
</html>
