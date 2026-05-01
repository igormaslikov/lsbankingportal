<!-- Minimal branded strip for customer-facing signing pages.
     Previously this file pulled a logo off an external domain that no longer
     resolves (gwadar-one.com), which showed up as a broken-image icon on every
     page that required_once() it. -->
<style>
    .sig-site-header {
        background: #1976d2;
        background-image: linear-gradient(to bottom, #2196f3, #1976d2);
        color: #fff;
        padding: 12px 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    .sig-site-header .sig-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        max-width: 980px;
        margin: 0 auto;
        font-weight: 600;
        font-size: 16px;
        letter-spacing: .2px;
    }
    .sig-site-header .sig-brand .dot {
        display: inline-block;
        width: 22px; height: 22px;
        background: #fff;
        color: #1976d2;
        border-radius: 50%;
        font-weight: 700;
        font-size: 13px;
        line-height: 22px;
        text-align: center;
    }
    .sig-site-header .sig-brand small {
        font-weight: 400;
        opacity: .85;
        font-size: 12px;
        margin-left: 6px;
    }
    @media (max-width: 640px) {
        .sig-site-header { padding: 10px 14px; }
        .sig-site-header .sig-brand { font-size: 15px; }
        .sig-site-header .sig-brand small { display: none; }
    }
</style>
<header class="sig-site-header">
    <div class="sig-brand">
        <span class="dot">$</span>
        <span>Optima Financial Solutions</span>
        <small>· secure contract signing</small>
    </div>
</header>
