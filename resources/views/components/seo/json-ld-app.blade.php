<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "WebApplication",
    "name": "{{ config('app.name', 'Todo App') }}",
    "description": "Free personal task manager with priorities, filters, and user-scoped todos.",
    "applicationCategory": "ProductivityApplication",
    "operatingSystem": "Web",
    "url": "{{ config('app.url') }}",
    "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    }
}
</script>
