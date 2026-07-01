<?php
include 'includes/header.php';
?>
<!-- INTEGRATED ABOUT US PAGE SYSTEM STYLES -->
<style>
    /* Hero Banner Architecture */
    .about-hero {
        background: linear-gradient(135deg, #111111 0%, #5a5a5a 100%);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: 0; right: 0; width: 50%; height: 100%;
        background: radial-gradient(circle, rgba(200,35,44,0.12) 0%, rgba(0,0,0,0) 80%);
        pointer-events: none;
    }

    /* Core Metrics Dashboard Counters */
    .metric-card {
        border-left: 3px solid #c8232c;
        padding-left: 20px;
        height: 100%;
    }
    .metric-number {
        font-size: 36px;
        font-weight: 800;
        color: #c8232c;
        line-height: 1.1;
        margin-bottom: 5px;
    }
    .metric-label {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #111111;
        letter-spacing: 0.05em;
    }

    /* Custom Timeline Infrastructure */
    .history-timeline {
        position: relative;
        padding: 20px 0;
    }
    .history-timeline::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 50%;
        width: 2px;
        background: #eeeeee;
        transform: translateX(-50%);
    }
    .timeline-node {
        position: relative;
        margin-bottom: 40px;
    }
    .timeline-node:last-child {
        margin-bottom: 0;
    }
    .timeline-marker {
        position: absolute;
        top: 5px; left: 50%;
        width: 16px; height: 16px;
        background: #ffffff;
        border: 4px solid #c8232c;
        border-radius: 50%;
        transform: translateX(-50%);
        z-index: 2;
    }
    .timeline-content {
        width: 45%;
        padding: 24px;
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.01);
        transition: border-color 0.3s ease;
    }
    .timeline-node:hover .timeline-content {
        border-color: #c8232c;
    }
    .timeline-node:nth-child(odd) .timeline-content {
        float: left;
        text-align: right;
    }
    .timeline-node:nth-child(even) .timeline-content {
        float: right;
        text-align: left;
    }
    .timeline-year {
        font-size: 20px;
        font-weight: 800;
        color: #c8232c;
        margin-bottom: 6px;
    }

    /* Clearfix for Custom Floating Timeline elements */
    .history-timeline::after, .timeline-node::after {
        content: "";
        display: table;
        clear: both;
    }

    /* Corporate Pillars Grid System */
    .pillar-card {
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 8px;
        padding: 35px 25px;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .pillar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.05);
        border-color: #eeeeee;
    }
    .pillar-icon-box {
        width: 50px; height: 50px;
        background: #fafafa;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }
    .pillar-card:hover .pillar-icon-box {
        background: rgba(200,35,44,0.06);
    }

    /* Responsive Design Media Rule Interventions */
    @media (max-width: 767.98px) {
        .history-timeline::before {
            left: 15px;
        }
        .timeline-marker {
            left: 15px;
        }
        .timeline-content {
            width: calc(100% - 40px);
            float: right !important;
            text-align: left !important;
            margin-left: 40px;
        }
    }
</style>

<!-- HEADER HERO BANNER SEGMENT -->
<section class="py-5 about-hero" style="font-family: 'Montserrat', sans-serif;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="text-uppercase d-block mb-2" style="color: #c8232c; font-size: 13px; font-weight: 700; letter-spacing: 0.1em;">Crafting Visual Identities Since 1998</span>
                <h1 class="text-uppercase mb-4" style="font-size: 42px; font-weight: 800; letter-spacing: 0.02em; line-height: 1.2;">
                    Pioneers in Premium Glass Decoration
                </h1>
                <p class="mb-0" style="color: #cccccc; font-size: 16px; line-height: 1.8; max-width: 620px;">
                    At Alok Glass, we combine state-of-the-art automation printing with master craftsmanship to transform standard glass bottles and jars into iconic, shelf-ready brand experiences.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- BRAND STORY & METRICS INFOGRAPHIC SEGMENT -->
<section class="py-5" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="text-uppercase mb-4" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                    Our Narrative
                    <span style="position: absolute; bottom: 0; left: 0; width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
                </h2>
                <p class="text-muted mb-3" style="font-size: 15px; line-height: 1.8; font-weight: 400;">
                    Founded with a vision to redefine value-added glass packaging, Alok Glass has evolved from a boutique processing facility into an industrial scale decoration hub. We cater to global supply chains across premium cosmetics, food & beverage, spirits, and pharmaceutical sectors.
                </p>
                <p class="text-muted mb-0" style="font-size: 15px; line-height: 1.8; font-weight: 400;">
                    We realize that packaging is the ultimate sensory touchpoint for your end-consumers. By introducing specialized low-MOQ capabilities alongside our automated high-throughput lines, we empower emerging independent brands and established market enterprises to bring custom packaging strategies to reality smoothly.
                </p>
            </div>
            
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="metric-card">
                            <div class="metric-number">25M+</div>
                            <div class="metric-label">Units Labeled Annually</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="metric-card">
                            <div class="metric-number">100%</div>
                            <div class="metric-label">Food-Grade Certified</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="metric-card">
                            <div class="metric-number">15+</div>
                            <div class="metric-label">Global Export Markets</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="metric-card">
                            <div class="metric-number">24/7</div>
                            <div class="metric-label">Technical Support Line</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BRAND MILESTONES CHRONOLOGICAL TIMELINE SEGMENT -->
<section class="py-5" style="background-color: #fafafa; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">
        
        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Our Strategic Evolution
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
        </div>

        <div class="history-timeline">
            
            <!-- Milestone Node 1 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">1998</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">The Inception</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">Established as a localized precision screen printing facility handling foundational configurations for regional cosmetic containers.</p>
                </div>
            </div>

            <!-- Milestone Node 2 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2008</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">Automation Integration</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">Commissioned multi-color automated rotary lines, dramatically multiplying production scale while lowering tolerances.</p>
                </div>
            </div>

            <!-- Milestone Node 3 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2018</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">Global Compliance</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">Acquired heavy toxic metal-free formulation lines and international food-safe operation accreditations for direct export lines.</p>
                </div>
            </div>

            <!-- Milestone Node 4 -->
            <div class="timeline-node">
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-year">2026</div>
                    <h5 style="font-weight: 700; font-size: 16px; color: #111111; margin-bottom: 8px;">Next-Gen Finishes</h5>
                    <p class="text-muted mb-0" style="font-size: 13.5px; line-height: 1.6;">Expanding into ultra-low MOQ digital glass printing and premium eco-friendly organic ink methodologies.</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- VALUES & OPERATIONAL PILLARS SEGMENT -->
<section class="py-5" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-3">

        <div class="text-center mb-5">
            <h2 class="text-uppercase mb-3" style="font-size: 28px; font-weight: 800; color: #111111; letter-spacing: 0.02em; position: relative; display: inline-block; padding-bottom: 14px;">
                Our Operational Pillars
                <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 4px; background: linear-gradient(90deg, #c8232c, #e0535a); border-radius: 2px;"></span>
            </h2>
        </div>

        <div class="row g-4">
            
            <!-- Pillar 1 -->
            <div class="col-md-4">
                <div class="pillar-card">
                    <div class="pillar-icon-box">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 700; color: #111111; margin-bottom: 12px;">Uncompromising Quality</h4>
                    <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.6;">Every run undergoes strict cross-hatch adhesion validation, thermal stress profiling, and dimensional verification tests to ensure defect-free performance on filling lines.</p>
                </div>
            </div>

            <!-- Pillar 2 -->
            <div class="col-md-4">
                <div class="pillar-card">
                    <div class="pillar-icon-box">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 700; color: #111111; margin-bottom: 12px;">Agile Turnaround</h4>
                    <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.6;">Through automated multi-stage inline systems and advanced pre-press engineering blocks, we dramatically accelerate prototyping-to-delivery workflows.</p>
                </div>
            </div>

            <!-- Pillar 3 -->
            <div class="col-md-4">
                <div class="pillar-card">
                    <div class="pillar-icon-box">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#c8232c" stroke-width="2.5"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                    </div>
                    <h4 style="font-size: 18px; font-weight: 700; color: #111111; margin-bottom: 12px;">Eco-Innovation</h4>
                    <p class="text-muted mb-0" style="font-size: 14px; line-height: 1.6;">We maintain active compliance with modern ecological thresholds by utilizing lead- and cadmium-free ink solutions alongside closed-loop clean wash processing layers.</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- CONVERSION-FOCUSED CLOSING CTA SEGMENT -->
<section class="py-5 text-center cta-premium-bg" style="font-family: 'Montserrat', sans-serif;">
    <div class="container py-4" style="position: relative; z-index: 2;">

        <h2 class="mb-3 text-uppercase" style="font-size: 28px; font-weight: 800; letter-spacing: 0.04em;">
            Partner With Alok Glass Today
        </h2>

        <p class="mb-4 mx-auto" style="font-size: 15px; font-weight: 400; max-width: 620px; color: #cccccc; line-height: 1.7;">
            Connect directly with our engineering and business consulting team to explore technical solutions for your custom branding goals.
        </p>

        <div class="mt-4 pt-2">
            <a href="bulk_inquiry.php" class="btn cta-btn-action text-uppercase">
                Request Bulk Quote
            </a>
        </div>

    </div>
</section>

<?php
include 'includes/footer.php';
?>