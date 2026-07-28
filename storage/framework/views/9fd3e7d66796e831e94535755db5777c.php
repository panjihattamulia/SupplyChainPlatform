<?php $__env->startSection('title','Country Dashboard'); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
<li class="breadcrumb-item active">Countries</li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#0A1E2E; --surface:#102A3D; --surface-raised:#16374C; --line:#20415A;
  --text:#EAF2F6; --text-dim:#7FA0B8;
  --cyan:#3FD0C9; --amber:#F0A947; --coral:#EF5B5B; --coral-deep:#C23A3A;
}
.ctr-wrap{ font-family:'Inter',sans-serif; color:var(--text); }
.ctr-eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; letter-spacing:.18em; text-transform:uppercase; color:var(--cyan); display:flex; align-items:center; gap:.5rem; margin-bottom:.3rem; }
.ctr-eyebrow::before{ content:''; width:6px; height:6px; border-radius:50%; background:var(--cyan); box-shadow:0 0 0 3px rgba(63,208,201,.25); }
.ctr-title{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.7rem; margin:0; }
.ctr-count{ font-family:'IBM Plex Mono',monospace; font-size:.75rem; color:var(--text-dim); }

/* Filter panel */
.ctr-filter{ background:var(--surface); border:1px solid var(--line); border-radius:16px; padding:1.1rem; margin-bottom:1.5rem; }
.ctr-input-shell{ position:relative; }
.ctr-input-shell i{ position:absolute; left:.9rem; top:50%; transform:translateY(-50%); color:var(--text-dim); font-size:.85rem; }
.ctr-input{
  width:100%; background:var(--ink); border:1px solid var(--line); color:var(--text); border-radius:10px;
  padding:.6rem .8rem .6rem 2.2rem; font-family:'Inter',sans-serif; font-size:.85rem;
}
.ctr-input::placeholder{ color:var(--text-dim); }
.ctr-input:focus, .ctr-select:focus{ outline:none; border-color:var(--cyan); box-shadow:0 0 0 3px rgba(63,208,201,.12); }
.ctr-select{
  width:100%; background:var(--ink); border:1px solid var(--line); color:var(--text); border-radius:10px;
  padding:.6rem .8rem; font-family:'Inter',sans-serif; font-size:.85rem;
}
.ctr-select option{ background:var(--surface); }
.ctr-filter-btn{
  width:100%; background:var(--cyan); border:none; color:#04211E; font-family:'Space Grotesk',sans-serif;
  font-weight:700; border-radius:10px; padding:.62rem; font-size:.85rem; transition:filter .15s, transform .15s;
}
.ctr-filter-btn:hover{ filter:brightness(1.08); transform:translateY(-1px); }

/* Country stamp card */
.ctr-card{
  background:var(--surface); border:1px solid var(--line); border-radius:16px; overflow:hidden; cursor:pointer;
  transition:transform .18s ease, border-color .18s ease, box-shadow .18s ease; height:100%; display:flex; flex-direction:column;
  position:relative;
}
.ctr-card:hover{ transform:translateY(-4px); border-color:var(--cyan); box-shadow:0 14px 30px -16px rgba(63,208,201,.35); }
.ctr-card-band{
  position:absolute; left:0; top:0; bottom:0; width:4px;
}
.ctr-card-flagzone{
  background:radial-gradient(circle at 30% 0%, #153a52 0%, var(--ink) 70%);
  padding:1.5rem 1rem 1.1rem; text-align:center; border-bottom:1px solid var(--line);
}
.ctr-flag-big{ font-size:3.4rem; line-height:1; filter:drop-shadow(0 6px 14px rgba(0,0,0,.35)); }
.ctr-card-body{ padding:1rem 1.1rem 1.1rem; flex:1; display:flex; flex-direction:column; }
.ctr-name{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.05rem; text-align:center; margin:0 0 .2rem; }
.ctr-meta{ font-family:'IBM Plex Mono',monospace; font-size:.68rem; color:var(--text-dim); text-align:center; margin-bottom:.7rem; }
.ctr-code-chip{ background:var(--surface-raised); border:1px solid var(--line); border-radius:6px; padding:0 .35rem; }

.ctr-region{ font-size:.76rem; color:var(--text-dim); display:flex; align-items:center; gap:.35rem; margin-bottom:.6rem; }
.ctr-region i{ color:var(--cyan); }

.ctr-risk-pill{
  font-family:'IBM Plex Mono',monospace; font-size:.68rem; font-weight:600; padding:.3rem .6rem; border-radius:20px;
  border:1px solid; display:inline-flex; align-items:center; gap:.35rem; align-self:flex-start;
}
.ctr-currency{ font-family:'IBM Plex Mono',monospace; font-size:.7rem; color:var(--text-dim); margin-top:.6rem; display:flex; align-items:center; gap:.35rem; }
.ctr-currency i{ color:var(--amber); }

.ctr-card-footer{ padding:0 1.1rem 1.1rem; margin-top:auto; }
.ctr-detail-btn{
  display:flex; align-items:center; justify-content:center; gap:.4rem; width:100%; background:transparent;
  border:1px solid var(--line); color:var(--text-dim); font-family:'Inter',sans-serif; font-size:.8rem; font-weight:500;
  border-radius:10px; padding:.5rem; text-decoration:none; transition:border-color .15s, color .15s, background .15s;
}
.ctr-card:hover .ctr-detail-btn{ border-color:var(--cyan); color:var(--cyan); background:rgba(63,208,201,.06); }

.ctr-empty{ text-align:center; color:var(--text-dim); padding:3.5rem 1rem; }
.ctr-empty i{ font-size:2.4rem; opacity:.3; display:block; margin-bottom:.8rem; }

.ctr-pagination{ margin-top:1.75rem; }
.ctr-pagination .page-link{ background:var(--surface); border-color:var(--line); color:var(--text); }
.ctr-pagination .page-link:hover{ background:var(--surface-raised); color:var(--cyan); }
.ctr-pagination .page-item.active .page-link{ background:var(--cyan); border-color:var(--cyan); color:#04211E; }
.ctr-pagination .page-item.disabled .page-link{ background:var(--surface); border-color:var(--line); color:var(--text-dim); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="ctr-wrap">

<div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
  <div>
    <div class="ctr-eyebrow">Global Directory</div>
    <h1 class="ctr-title">Country Dashboard</h1>
  </div>
  <div class="ctr-count"><?php echo e($countries->total() ?? $countries->count()); ?> NEGARA TERDAFTAR</div>
</div>

<div class="ctr-filter">
  <form method="GET" action="<?php echo e(route('countries.index')); ?>" class="row g-3 align-items-end">
    <div class="col-md-5">
      <div class="ctr-input-shell">
        <i class="bi bi-search"></i>
        <input type="text" name="search" class="ctr-input" placeholder="Cari negara..." value="<?php echo e(request('search')); ?>">
      </div>
    </div>
    <div class="col-md-4">
      <select name="region" class="ctr-select">
        <option value="">Semua Region</option>
        <?php $__currentLoopData = $regions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($region); ?>" <?php echo e(request('region')==$region?'selected':''); ?>><?php echo e($region); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </select>
    </div>
    <div class="col-md-3">
      <button type="submit" class="ctr-filter-btn"><i class="bi bi-funnel me-1"></i>Filter</button>
    </div>
  </form>
</div>

<div class="row g-3">
  <?php $__empty_1 = true; $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <?php
    $level = $country->latestRiskScore->risk_level ?? null;
    [$riskColor,$riskBg] = match($level){
      'low' => ['var(--cyan)','rgba(63,208,201,.10)'],
      'medium' => ['var(--amber)','rgba(240,169,71,.10)'],
      'high' => ['var(--coral)','rgba(239,91,91,.10)'],
      'critical' => ['var(--coral-deep)','rgba(194,58,58,.14)'],
      default => ['var(--text-dim)','rgba(127,160,184,.08)'],
    };
  ?>
  <div class="col-sm-6 col-md-4 col-xl-3">
    <div class="ctr-card" onclick="window.location='<?php echo e(route('countries.show',$country->code)); ?>'">
      <div class="ctr-card-band" style="background:<?php echo e($riskColor); ?>"></div>
      <div class="ctr-card-flagzone">
        <div class="ctr-flag-big"><?php echo e($country->flag_emoji); ?></div>
      </div>
      <div class="ctr-card-body">
        <div class="ctr-name"><?php echo e($country->name); ?></div>
        <div class="ctr-meta"><?php echo e($country->capital); ?> · <span class="ctr-code-chip"><?php echo e($country->code); ?></span></div>

        <div class="ctr-region"><i class="bi bi-geo-alt"></i><?php echo e($country->region); ?><?php if($country->subregion): ?> · <?php echo e($country->subregion); ?><?php endif; ?></div>

        <?php if($country->latestRiskScore): ?>
        <span class="ctr-risk-pill" style="color:<?php echo e($riskColor); ?>;background:<?php echo e($riskBg); ?>;border-color:<?php echo e($riskColor); ?>">
          <?php echo e($country->latestRiskScore->risk_label); ?> · <?php echo e(number_format($country->latestRiskScore->total_score,1)); ?>

        </span>
        <?php endif; ?>

        <?php if($country->currency_code): ?>
        <div class="ctr-currency"><i class="bi bi-currency-exchange"></i><?php echo e($country->currency_code); ?></div>
        <?php endif; ?>
      </div>
      <div class="ctr-card-footer">
        <a href="<?php echo e(route('countries.show',$country->code)); ?>" class="ctr-detail-btn" onclick="event.stopPropagation()">
          <i class="bi bi-eye"></i>Lihat Detail
        </a>
      </div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
  <div class="col-12">
    <div class="ctr-empty">
      <i class="bi bi-search"></i>
      Tidak ada negara ditemukan.
    </div>
  </div>
  <?php endif; ?>
</div>

<div class="ctr-pagination"><?php echo e($countries->withQueryString()->links()); ?></div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Global Supply\supply-chain-platform\resources\views/countries/index.blade.php ENDPATH**/ ?>