@extends('layouts.app')

@section('title','Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<style>
  /* ===================================================================
     GLOBAL TRADE WATCH — command-center design tokens
     =================================================================== */
  :root{
    --gtw-ink:        #0A1420;
    --gtw-surface:    #0F1C2E;
    --gtw-surface-2:  #14273F;
    --gtw-line:       rgba(148,178,208,.14);
    --gtw-text:       #E9F2FA;
    --gtw-muted:      #7E93AC;
    --gtw-cyan:       #2DD4E8;
    --gtw-cyan-dim:   rgba(45,212,232,.14);
    --gtw-amber:      #F5A623;
    --gtw-amber-dim:  rgba(245,166,35,.14);
    --gtw-coral:      #FF5470;
    --gtw-coral-dim:  rgba(255,84,112,.14);
    --gtw-mint:       #34E1A1;
    --gtw-mint-dim:   rgba(52,225,161,.14);
    --gtw-violet:     #9B8CFF;
    --gtw-radius:     16px;
  }

  #gtw-root{
    background: var(--gtw-ink);
    color: var(--gtw-text);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;
    padding: 4px 4px 24px;
    border-radius: 20px;
  }
  #gtw-root .gtw-display{
    font-family:'Space Grotesk','Inter',sans-serif;
    letter-spacing:-.01em;
  }
  #gtw-root .gtw-mono{
    font-family:'JetBrains Mono','IBM Plex Mono',monospace;
  }

  /* -- top strip: live indicator + date ------------------------------ */
  .gtw-topline{
    display:flex; align-items:center; justify-content:space-between;
    padding:2px 6px 18px;
    color:var(--gtw-muted); font-size:.78rem;
  }
  .gtw-live{
    display:inline-flex; align-items:center; gap:8px;
    font-family:'JetBrains Mono',monospace; letter-spacing:.08em;
    color:var(--gtw-mint); font-size:.72rem; text-transform:uppercase;
  }
  .gtw-live-dot{
    width:8px; height:8px; border-radius:50%;
    background:var(--gtw-mint);
    box-shadow:0 0 0 0 rgba(52,225,161,.6);
    animation: gtw-pulse 2s infinite;
  }
  @keyframes gtw-pulse{
    0%{ box-shadow:0 0 0 0 rgba(52,225,161,.55); }
    70%{ box-shadow:0 0 0 8px rgba(52,225,161,0); }
    100%{ box-shadow:0 0 0 0 rgba(52,225,161,0); }
  }
  @media (prefers-reduced-motion: reduce){
    .gtw-live-dot{ animation:none; }
  }

  /* -- stat cards ------------------------------------------------------ */
  .gtw-stat{
    position:relative;
    background:var(--gtw-surface);
    border:1px solid var(--gtw-line);
    border-radius:var(--gtw-radius);
    padding:20px 20px 18px;
    overflow:hidden;
    transition:transform .18s ease, border-color .18s ease;
  }
  .gtw-stat:hover{ transform:translateY(-2px); border-color:rgba(148,178,208,.28); }
  .gtw-stat::before{
    content:''; position:absolute; left:0; top:0; bottom:0; width:3px;
    background:var(--accent);
  }
  .gtw-stat .gtw-stat-icon{
    width:38px; height:38px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    background:var(--accent-dim); color:var(--accent);
    font-size:1.05rem; flex-shrink:0;
  }
  .gtw-stat .gtw-stat-value{
    font-size:2rem; font-weight:700; line-height:1;
    font-family:'Space Grotesk',sans-serif;
  }
  .gtw-stat .gtw-stat-label{
    color:var(--gtw-muted); font-size:.76rem; margin-top:6px;
    text-transform:uppercase; letter-spacing:.06em;
  }

  /* -- generic card shell ---------------------------------------------- */
  .gtw-card{
    background:var(--gtw-surface);
    border:1px solid var(--gtw-line);
    border-radius:var(--gtw-radius);
    height:100%;
  }
  .gtw-card-header{
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 20px; border-bottom:1px solid var(--gtw-line);
    font-weight:600; font-size:.92rem;
  }
  .gtw-card-header .gtw-eyebrow{
    color:var(--gtw-muted); font-weight:500; font-size:.68rem;
    text-transform:uppercase; letter-spacing:.08em; display:block; margin-bottom:2px;
  }
  .gtw-card-body{ padding:0; }
  .gtw-btn{
    font-size:.74rem; padding:5px 12px; border-radius:20px;
    border:1px solid var(--gtw-line); color:var(--gtw-text);
    text-decoration:none; transition:all .15s ease; white-space:nowrap;
  }
  .gtw-btn:hover{ background:var(--gtw-cyan-dim); border-color:var(--gtw-cyan); color:var(--gtw-cyan); }

  /* -- risk table -------------------------------------------------------*/
  .gtw-table{ width:100%; border-collapse:collapse; }
  .gtw-table thead th{
    background:transparent; color:var(--gtw-muted);
    font-size:.68rem; text-transform:uppercase; letter-spacing:.08em;
    font-weight:600; padding:10px 20px; border-bottom:1px solid var(--gtw-line);
    text-align:left;
  }
  .gtw-table tbody td{
    padding:12px 20px; border-bottom:1px solid var(--gtw-line);
    font-size:.86rem; vertical-align:middle;
  }
  .gtw-table tbody tr{ transition:background .15s ease; }
  .gtw-table tbody tr:hover{ background:var(--gtw-surface-2); }
  .gtw-table tbody tr:last-child td{ border-bottom:none; }
  .gtw-country-link{
    color:var(--gtw-text); text-decoration:none; font-weight:600;
    display:flex; align-items:center; gap:8px;
  }
  .gtw-country-link:hover{ color:var(--gtw-cyan); }
  .gtw-metric{ color:var(--gtw-muted); font-family:'JetBrains Mono',monospace; font-size:.8rem; }

  /* risk score readout — mono figure + horizontal meter */
  .gtw-score-wrap{ display:flex; flex-direction:column; align-items:center; gap:5px; min-width:104px; }
  .gtw-score-fig{
    font-family:'JetBrains Mono',monospace; font-weight:700; font-size:.92rem;
    display:flex; align-items:center; gap:6px;
  }
  .gtw-score-meter{
    width:100%; height:5px; border-radius:3px; background:rgba(148,178,208,.14);
    overflow:hidden;
  }
  .gtw-score-meter > span{ display:block; height:100%; border-radius:3px; }
  .gtw-score-label{ font-size:.65rem; text-transform:uppercase; letter-spacing:.06em; }

  .gtw-risk-low       { color:var(--gtw-mint); }
  .gtw-risk-medium    { color:var(--gtw-amber); }
  .gtw-risk-high      { color:var(--gtw-coral); }
  .gtw-risk-critical  { color:var(--gtw-coral); }
  .gtw-meter-low      { background:linear-gradient(90deg,var(--gtw-mint),#7EF0C4); }
  .gtw-meter-medium   { background:linear-gradient(90deg,var(--gtw-amber),#FFCB6B); }
  .gtw-meter-high,
  .gtw-meter-critical { background:linear-gradient(90deg,var(--gtw-coral),#FF8FA3); }

  .gtw-pulse-dot{
    width:7px; height:7px; border-radius:50%; background:var(--gtw-coral); flex-shrink:0;
    box-shadow:0 0 0 0 rgba(255,84,112,.6); animation:gtw-pulse-red 1.8s infinite;
  }
  @keyframes gtw-pulse-red{
    0%{ box-shadow:0 0 0 0 rgba(255,84,112,.55); }
    70%{ box-shadow:0 0 0 7px rgba(255,84,112,0); }
    100%{ box-shadow:0 0 0 0 rgba(255,84,112,0); }
  }
  @media (prefers-reduced-motion: reduce){ .gtw-pulse-dot{ animation:none; } }

  /* -- watchlist --------------------------------------------------------*/
  .gtw-watch-item{
    display:flex; align-items:center; justify-content:space-between;
    padding:12px 20px; border-bottom:1px solid var(--gtw-line);
    transition:background .15s ease;
  }
  .gtw-watch-item:last-child{ border-bottom:none; }
  .gtw-watch-item:hover{ background:var(--gtw-surface-2); }
  .gtw-watch-name{ font-weight:600; font-size:.86rem; }
  .gtw-empty{ text-align:center; color:var(--gtw-muted); font-size:.82rem; padding:28px 16px; }

  /* -- news --------------------------------------------------------------*/
  .gtw-news-item{
    padding:13px 20px; border-bottom:1px solid var(--gtw-line);
    border-left:3px solid transparent;
    transition:background .15s ease, border-color .15s ease;
  }
  .gtw-news-item:last-child{ border-bottom:none; }
  .gtw-news-item:hover{ background:var(--gtw-surface-2); }
  .gtw-news-item[data-sentiment="positive"]{ border-left-color:var(--gtw-mint); }
  .gtw-news-item[data-sentiment="neutral"]{ border-left-color:var(--gtw-muted); }
  .gtw-news-item[data-sentiment="negative"]{ border-left-color:var(--gtw-coral); }
  .gtw-news-badge{
    font-size:.62rem; text-transform:uppercase; letter-spacing:.06em; font-weight:700;
    padding:2px 8px; border-radius:10px;
  }
  .gtw-news-title{
    color:var(--gtw-text); text-decoration:none; font-size:.84rem; font-weight:500;
    line-height:1.4; display:block; margin-top:6px;
  }
  .gtw-news-title:hover{ color:var(--gtw-cyan); }
  .gtw-news-time{ color:var(--gtw-muted); font-size:.72rem; font-family:'JetBrains Mono',monospace; }

  /* -- map ----------------------------------------------------------------*/
  #worldMap{ background:var(--gtw-surface); border-radius:0 0 var(--gtw-radius) var(--gtw-radius); }
  .leaflet-popup-content-wrapper{
    background:var(--gtw-surface-2); color:var(--gtw-text); border-radius:10px;
  }
  .leaflet-popup-tip{ background:var(--gtw-surface-2); }

  @media (max-width:767px){
    .gtw-stat .gtw-stat-value{ font-size:1.5rem; }
  }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<div id="gtw-root">

  <div class="gtw-topline">
    <span class="gtw-live"><span class="gtw-live-dot"></span> Live monitoring</span>
    <span class="gtw-mono">{{ today()->format('d M Y') }}</span>
  </div>

  <!-- Stats Row -->
  <div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
      <div class="gtw-stat" style="--accent:var(--gtw-cyan); --accent-dim:var(--gtw-cyan-dim)">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="gtw-stat-value">{{ $stats['total_countries'] }}</div>
            <div class="gtw-stat-label">Negara Dipantau</div>
          </div>
          <div class="gtw-stat-icon"><i class="bi bi-globe2"></i></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="gtw-stat" style="--accent:var(--gtw-mint); --accent-dim:var(--gtw-mint-dim)">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="gtw-stat-value">{{ $stats['total_ports'] }}</div>
            <div class="gtw-stat-label">Pelabuhan Dunia</div>
          </div>
          <div class="gtw-stat-icon"><i class="bi bi-anchor"></i></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="gtw-stat" style="--accent:var(--gtw-coral); --accent-dim:var(--gtw-coral-dim)">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="gtw-stat-value">{{ $stats['high_risk_count'] }}</div>
            <div class="gtw-stat-label">High Risk Today</div>
          </div>
          <div class="gtw-stat-icon"><i class="bi bi-exclamation-triangle"></i></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="gtw-stat" style="--accent:var(--gtw-violet); --accent-dim:rgba(155,140,255,.14)">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="gtw-stat-value">{{ $stats['news_count'] }}</div>
            <div class="gtw-stat-label">Berita 24 Jam</div>
          </div>
          <div class="gtw-stat-icon"><i class="bi bi-newspaper"></i></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Risk Scores Row -->
  <div class="row g-3 mb-3">
    <div class="col-12 col-lg-8">
      <div class="gtw-card">
        <div class="gtw-card-header">
          <span>
            <span class="gtw-eyebrow">Risk scoring</span>
            <span class="gtw-display"><i class="bi bi-shield-exclamation me-1" style="color:var(--gtw-cyan)"></i> Country risk board</span>
          </span>
          <a href="{{ route('countries.index') }}" class="gtw-btn">Lihat Semua</a>
        </div>
        <div class="gtw-card-body">
          <div class="table-responsive">
            <table class="gtw-table">
              <thead>
                <tr><th>Negara</th><th>Weather</th><th>Inflasi</th><th>Kurs</th><th>Berita</th><th style="text-align:center">Risk Score</th></tr>
              </thead>
              <tbody>
                @foreach($riskScores as $code => $risk)
                <tr>
                  <td>
                    <a href="{{ route('countries.show',$code) }}" class="gtw-country-link">
                      @if(($risk['risk_level'] ?? '') === 'high' || ($risk['risk_level'] ?? '') === 'critical')
                        <span class="gtw-pulse-dot"></span>
                      @endif
                      <span>{{ $risk['flag_emoji'] ?? '' }} {{ $risk['country_name'] }}</span>
                    </a>
                  </td>
                  <td><span class="gtw-metric">{{ number_format($risk['weather_score'],1) }}</span></td>
                  <td><span class="gtw-metric">{{ number_format($risk['inflation_score'],1) }}</span></td>
                  <td><span class="gtw-metric">{{ number_format($risk['currency_score'],1) }}</span></td>
                  <td><span class="gtw-metric">{{ number_format($risk['news_sentiment_score'],1) }}</span></td>
                  <td>
                    <div class="gtw-score-wrap">
                      <span class="gtw-score-fig gtw-risk-{{ $risk['risk_level'] }}">{{ number_format($risk['total_score'],1) }}</span>
                      <span class="gtw-score-meter"><span class="gtw-meter-{{ $risk['risk_level'] }}" style="width:{{ min(100, $risk['total_score']) }}%"></span></span>
                      <span class="gtw-score-label gtw-risk-{{ $risk['risk_level'] }}">{{ $risk['risk_label'] }}</span>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <!-- Risk Distribution Pie -->
      <div class="gtw-card mb-3">
        <div class="gtw-card-header">
          <span>
            <span class="gtw-eyebrow">Breakdown</span>
            <span class="gtw-display"><i class="bi bi-pie-chart me-1" style="color:var(--gtw-cyan)"></i> Risk distribution</span>
          </span>
        </div>
        <div style="padding:18px 20px">
          <canvas id="riskPieChart" height="160"></canvas>
        </div>
      </div>

      <!-- Watchlist -->
      <div class="gtw-card">
        <div class="gtw-card-header">
          <span>
            <span class="gtw-eyebrow">Tracked</span>
            <span class="gtw-display"><i class="bi bi-star me-1" style="color:var(--gtw-amber)"></i> Watchlist</span>
          </span>
          <a href="{{ route('watchlist.index') }}" class="gtw-btn">Kelola</a>
        </div>
        <div class="gtw-card-body">
          @forelse($watchlist as $item)
          <div class="gtw-watch-item">
            <span class="gtw-watch-name">{{ $item->country->flag_emoji ?? '' }} {{ $item->country_name }}</span>
            <a href="{{ route('countries.show',$item->country_code) }}" class="gtw-btn">Detail</a>
          </div>
          @empty
          <div class="gtw-empty">Belum ada negara di watchlist</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- World Map + Latest News Row -->
  <div class="row g-3">
    <div class="col-12 col-lg-8">
      <div class="gtw-card">
        <div class="gtw-card-header">
          <span>
            <span class="gtw-eyebrow">Live map</span>
            <span class="gtw-display"><i class="bi bi-map me-1" style="color:var(--gtw-cyan)"></i> Global risk map</span>
          </span>
        </div>
        <div class="gtw-card-body">
          <div id="worldMap" style="height:380px"></div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="gtw-card">
        <div class="gtw-card-header">
          <span>
            <span class="gtw-eyebrow">Newsroom</span>
            <span class="gtw-display"><i class="bi bi-newspaper me-1" style="color:var(--gtw-violet)"></i> Berita terbaru</span>
          </span>
          <a href="{{ route('news.index') }}" class="gtw-btn">Semua</a>
        </div>
        <div class="gtw-card-body">
          @forelse($latestNews as $news)
          <div class="gtw-news-item" data-sentiment="{{ $news->sentiment }}">
            <div class="d-flex justify-content-between align-items-center">
              <span class="gtw-news-badge" style="background:var(--gtw-{{ $news->sentiment === 'positive' ? 'mint' : ($news->sentiment === 'negative' ? 'coral' : 'muted') }}-dim, rgba(148,178,208,.14)); color:{{ $news->sentiment === 'positive' ? 'var(--gtw-mint)' : ($news->sentiment === 'negative' ? 'var(--gtw-coral)' : 'var(--gtw-muted)') }}">{{ ucfirst($news->sentiment) }}</span>
              <span class="gtw-news-time">{{ $news->time_ago }}</span>
            </div>
            <a href="{{ $news->url }}" target="_blank" class="gtw-news-title">{{ Str::limit($news->title, 80) }}</a>
          </div>
          @empty
          <div class="gtw-empty">Tidak ada berita</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// ── Risk Pie Chart ──────────────────────────────────────────
const gtwStyles = getComputedStyle(document.documentElement);
const gtwColor = (name, fallback) => (gtwStyles.getPropertyValue(name) || fallback).trim();

const riskColorMap = {
  low: gtwColor('--gtw-mint', '#34E1A1'),
  medium: gtwColor('--gtw-amber', '#F5A623'),
  high: gtwColor('--gtw-coral', '#FF5470'),
  critical: gtwColor('--gtw-coral', '#FF5470'),
};
function riskColor(level){ return riskColorMap[level] || '#7E93AC'; }
function riskBg(level){ return riskColor(level); }

const riskDist = @json($riskDist ?? []);
const pieLabels = Object.keys(riskDist).map(l=>l.charAt(0).toUpperCase()+l.slice(1));
const pieData   = Object.values(riskDist);
const pieColors = Object.keys(riskDist).map(l=>riskColor(l));

new Chart(document.getElementById('riskPieChart').getContext('2d'),{
  type:'doughnut',
  data:{labels:pieLabels,datasets:[{data:pieData,backgroundColor:pieColors,borderWidth:2,borderColor:gtwColor('--gtw-surface','#0F1C2E')}]},
  options:{
    responsive:true,
    plugins:{ legend:{ position:'bottom', labels:{ padding:10, font:{size:11}, color:gtwColor('--gtw-text','#E9F2FA') } } },
    cutout:'62%'
  }
});

// ── World Risk Map (Leaflet.js, dark tiles) ─────────────────
const worldMap = L.map('worldMap',{zoom:2,center:[20,0],zoomControl:true});
L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
  attribution:'© <a href="https://openstreetmap.org">OpenStreetMap</a> © <a href="https://carto.com/attributions">CARTO</a>',
  maxZoom:18, subdomains:'abcd'
}).addTo(worldMap);

const allRisks = @json($allRisks ?? []);
allRisks.forEach(r => {
  if (!r.lat || !r.lng) return;
  const marker = L.circleMarker([r.lat, r.lng], {
    radius:9, color:gtwColor('--gtw-surface','#0F1C2E'), weight:2,
    fillColor:r.color, fillOpacity:.9
  }).addTo(worldMap);
  marker.bindPopup(`
    <b>${r.name}</b><br>
    <span style="background:${riskBg(r.level)};color:#0A1420;padding:2px 8px;border-radius:10px;font-size:.8rem;font-weight:700">${r.label}: ${r.score.toFixed(1)}</span>
  `);
});

// Default risk scores dari dashboard
const defaultRisks = @json($riskScores ?? []);
Object.values(defaultRisks).forEach(r => {
  const weather = r.raw_weather;
  if (!weather || !weather.latitude) return;
  const existing = allRisks.find(x=>x.code===r.country_code);
  if (existing) return;
  L.circleMarker([weather.latitude, weather.longitude], {
    radius:9, color:gtwColor('--gtw-surface','#0F1C2E'), weight:2,
    fillColor:r.marker_color, fillOpacity:.9
  }).addTo(worldMap)
   .bindPopup(`<b>${r.country_name}</b><br><span>${r.risk_label}: ${r.total_score.toFixed(1)}</span>`);
});
</script>
@endpush