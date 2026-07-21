<?php $__env->startSection('title','Global Weather Monitoring'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Weather Monitoring</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
  /* ===================================================================
     GLOBAL TRADE WATCH — command-center design tokens (shared)
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
  #gtw-root .gtw-display{ font-family:'Space Grotesk','Inter',sans-serif; letter-spacing:-.01em; }
  #gtw-root .gtw-mono{ font-family:'JetBrains Mono','IBM Plex Mono',monospace; }

  .gtw-header-row{ display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:12px; }
  .gtw-page-title{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.3rem; margin:0; display:flex; align-items:center; gap:10px; }
  .gtw-page-title i{ color:var(--gtw-cyan); }

  .gtw-select{
    background:var(--gtw-surface); color:var(--gtw-text);
    border:1px solid var(--gtw-line); border-radius:10px;
    font-size:.82rem; padding:7px 12px; width:220px;
  }
  .gtw-select:focus{ outline:none; border-color:var(--gtw-cyan); box-shadow:0 0 0 3px var(--gtw-cyan-dim); }

  .gtw-card{ background:var(--gtw-surface); border:1px solid var(--gtw-line); border-radius:var(--gtw-radius); }
  .gtw-card-header{
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 20px; border-bottom:1px solid var(--gtw-line); font-weight:600; font-size:.92rem;
  }
  .gtw-card-header small{ color:var(--gtw-muted); font-weight:400; }

  /* legend strip */
  .gtw-legend{ display:flex; flex-wrap:wrap; align-items:center; gap:18px; padding:14px 20px; }
  .gtw-legend-label{ color:var(--gtw-muted); font-size:.72rem; text-transform:uppercase; letter-spacing:.08em; font-weight:600; }
  .gtw-legend-item{ display:flex; align-items:center; gap:7px; font-size:.8rem; color:var(--gtw-text); }
  .gtw-dot{ width:10px; height:10px; border-radius:50%; flex-shrink:0; }

  #weatherMap{ background:var(--gtw-surface); }
  .leaflet-popup-content-wrapper{ background:var(--gtw-surface-2); color:var(--gtw-text); border-radius:10px; }
  .leaflet-popup-tip{ background:var(--gtw-surface-2); }

  /* weather cards */
  .gtw-wcard{
    background:var(--gtw-surface); border:1px solid var(--gtw-line); border-radius:14px;
    padding:18px 14px; text-align:center; cursor:pointer; height:100%;
    transition:transform .16s ease, border-color .16s ease, background .16s ease;
    position:relative; overflow:hidden;
  }
  .gtw-wcard:hover{ transform:translateY(-3px); border-color:var(--gtw-cyan); background:var(--gtw-surface-2); }
  .gtw-wcard::before{
    content:''; position:absolute; left:0; top:0; right:0; height:3px; background:var(--risk-color, var(--gtw-mint));
  }
  .gtw-wicon{ font-size:1.9rem; line-height:1; }
  .gtw-wname{ font-weight:600; font-size:.82rem; margin-top:8px; }
  .gtw-wtemp{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.5rem; margin-top:2px; }
  .gtw-wdesc{ color:var(--gtw-muted); font-size:.7rem; margin-top:2px; min-height:14px; }
  .gtw-wbadge{
    display:inline-block; margin-top:8px; font-size:.66rem; font-weight:700;
    padding:3px 10px; border-radius:20px; letter-spacing:.03em;
  }
  .gtw-wbadge-success{ background:var(--gtw-mint-dim); color:var(--gtw-mint); }
  .gtw-wbadge-warning{ background:var(--gtw-amber-dim); color:var(--gtw-amber); }
  .gtw-wbadge-danger{ background:var(--gtw-coral-dim); color:var(--gtw-coral); }
  .gtw-walerts{ display:flex; justify-content:center; gap:6px; margin-top:6px; font-size:.9rem; }

  .gtw-empty{
    grid-column:1/-1; text-align:center; padding:60px 20px; color:var(--gtw-muted);
  }
  .gtw-empty i{ font-size:2.6rem; opacity:.25; display:block; margin-bottom:12px; }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<div id="gtw-root">

  <div class="gtw-header-row">
    <h4 class="gtw-page-title"><i class="bi bi-cloud-sun"></i>Global Weather Monitoring</h4>
    <select class="gtw-select" onchange="if(this.value)window.location='/weather/'+this.value">
      <option value="">Pilih Negara...</option>
      <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->code); ?>"><?php echo e($c->flag_emoji); ?> <?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </div>

  <div class="gtw-card mb-3">
    <div class="gtw-legend">
      <span class="gtw-legend-label">Legend</span>
      <span class="gtw-legend-item"><span class="gtw-dot" style="background:var(--gtw-mint)"></span>Low Risk (0-30)</span>
      <span class="gtw-legend-item"><span class="gtw-dot" style="background:var(--gtw-amber)"></span>Medium Risk (31-60)</span>
      <span class="gtw-legend-item"><span class="gtw-dot" style="background:var(--gtw-coral)"></span>High Risk (61+)</span>
      <span class="gtw-legend-item">⛈️ Badai</span>
      <span class="gtw-legend-item">🌧️ Hujan Lebat</span>
      <span class="gtw-legend-item">💨 Angin Kencang</span>
    </div>
  </div>

  <div class="gtw-card mb-4">
    <div class="gtw-card-header">
      <span><i class="bi bi-map me-2"></i>Peta Cuaca Dunia <small>— Klik marker untuk detail</small></span>
    </div>
    <div style="padding:0"><div id="weatherMap" style="height:450px;border-radius:0 0 var(--gtw-radius) var(--gtw-radius)"></div></div>
  </div>

  <div class="row g-3">
    <?php $__empty_1 = true; $__currentLoopData = $mapMarkers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
      $rs = $w['risk_score'] ?? 0;
      $rl = $rs>60 ? 'danger' : ($rs>30 ? 'warning' : 'success');
      $riskVar = $rs>60 ? 'var(--gtw-coral)' : ($rs>30 ? 'var(--gtw-amber)' : 'var(--gtw-mint)');
      $wc = $w['weathercode'] ?? 0;
      $icon = match(true){
        in_array($wc,[0,1]) => '☀️',
        in_array($wc,[2,3]) => '⛅',
        in_array($wc,[45,48]) => '🌫️',
        in_array($wc,[51,61,63]) => '🌦️',
        in_array($wc,[65,80,81,82]) => '🌧️',
        in_array($wc,[95,96,99]) => '⛈️',
        default => '🌡️'
      };
    ?>
    <div class="col-6 col-md-4 col-lg-3">
      <div class="gtw-wcard" style="--risk-color:<?php echo e($riskVar); ?>" onclick="window.location='/weather/<?php echo e($w['country_code']); ?>'">
        <div class="gtw-wicon"><?php echo e($icon); ?></div>
        <div class="gtw-wname"><?php echo e($w['country_name']); ?></div>
        <?php if($w['temperature']!==null): ?><div class="gtw-wtemp"><?php echo e(number_format($w['temperature'],1)); ?>°C</div><?php endif; ?>
        <div class="gtw-wdesc"><?php echo e($w['description'] ?? ''); ?></div>
        <span class="gtw-wbadge gtw-wbadge-<?php echo e($rl); ?>">Risk <?php echo e(round($rs)); ?></span>
        <div class="gtw-walerts">
          <?php if($w['is_storm']??false): ?><span title="Badai">⛈️</span><?php endif; ?>
          <?php if($w['is_heavy_rain']??false): ?><span title="Hujan Lebat">🌧️</span><?php endif; ?>
          <?php if($w['is_strong_wind']??false): ?><span title="Angin Kencang">💨</span><?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="gtw-empty">
      <i class="bi bi-cloud-slash"></i>Belum ada data cuaca. Pilih negara dari dropdown.
    </div>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
const gtwStylesW = getComputedStyle(document.documentElement);
const gtwColorW = (name, fallback) => (gtwStylesW.getPropertyValue(name) || fallback).trim();

const wMap = L.map('weatherMap',{zoom:2,center:[20,0]});
L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
  attribution:'© <a href="https://openstreetmap.org">OpenStreetMap</a> © <a href="https://carto.com/attributions">CARTO</a>',
  maxZoom:18, subdomains:'abcd'
}).addTo(wMap);

const mks = <?php echo json_encode($mapMarkers ?? [], 15, 512) ?>;
mks.forEach(w=>{
  if(!w.lat||!w.lng) return;
  const rs = w.risk_score || 0;
  const col = rs>60 ? gtwColorW('--gtw-coral','#FF5470') : (rs>30 ? gtwColorW('--gtw-amber','#F5A623') : gtwColorW('--gtw-mint','#34E1A1'));
  L.circleMarker([w.lat,w.lng],{radius:9,color:gtwColorW('--gtw-surface','#0F1C2E'),weight:2,fillColor:col,fillOpacity:.9}).addTo(wMap)
   .bindPopup(`<b>${w.country_name}</b><br><span style="font-size:1.2rem">${w.temperature!==null?w.temperature.toFixed(1)+'°C':'--'}</span><br><small>${w.description||''}</small><br>🌧️${w.precipitation||0}mm 💨${w.windspeed||0}km/h<br><span style="background:${col};color:#0A1420;padding:2px 8px;border-radius:10px;font-size:.75rem;font-weight:700">Risk:${rs.toFixed(0)}</span>`)
   .on('click',()=>{window.location='/weather/'+w.country_code;});
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Global Supply\supply-chain-platform\resources\views/weather/index.blade.php ENDPATH**/ ?>