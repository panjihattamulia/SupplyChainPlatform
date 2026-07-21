<?php $__env->startSection('title', 'Visualisasi — ' . $country->name); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">
    <a href="<?php echo e(route('visualization.index')); ?>">Visualization</a>
</li>
<li class="breadcrumb-item active">
    <?php echo e($country->name); ?>

</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card mb-4 border-0 text-white"
    style="background:linear-gradient(135deg,#1a1d23,#0d3880);">

    <div class="card-body py-3 d-flex align-items-center gap-3">

        <span style="font-size:2.7rem">
            <?php echo e($country->flag_emoji ?? '🏳️'); ?>

        </span>

        <div class="flex-fill">

            <h4 class="fw-bold mb-1 text-white">
                <?php echo e($country->name); ?>

            </h4>

            <small class="opacity-75">
                <?php echo e($country->region); ?>

                ·
                <?php echo e($country->subregion); ?>

            </small>

        </div>

        <?php if($riskScore): ?>

        <div class="text-end">

            <h2 class="fw-bold mb-1"
                style="color:<?php echo e($riskScore['marker_color'] ?? '#fff'); ?>">

                <?php echo e(number_format($riskScore['total_score'],1)); ?>


            </h2>

            <span class="badge bg-<?php echo e($riskScore['risk_badge_class'] ?? 'secondary'); ?>">

                <?php echo e($riskScore['risk_label'] ?? '-'); ?>


            </span>

        </div>

        <?php endif; ?>

    </div>

</div>


<div class="row g-4 mb-4">

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                GDP Trend (5 Tahun)

            </div>

            <div class="card-body">

                <canvas id="gdpC" height="220"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Inflation Trend (5 Tahun)

            </div>

            <div class="card-body">

                <canvas id="inflC" height="220"></canvas>

            </div>

        </div>

    </div>

</div>


<div class="row g-4">

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Currency Trend (30 Hari)

            </div>

            <div class="card-body">

                <canvas id="currC" height="220"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card h-100">

            <div class="card-header fw-semibold">

                Risk Trend (30 Hari)

            </div>

            <div class="card-body">

                <canvas id="riskC" height="220"></canvas>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>

<?php

$g = $gdpTrend ?? [];

$inf = $inflationTrend ?? [];

$rt = $riskTrend ?? [];

$currencyTrend = $currencyTrend ?? [];

$riskColors = [];

foreach(($rt['levels'] ?? []) as $level){

    switch($level){

        case 'low':
            $riskColors[]='#198754';
            break;

        case 'medium':
            $riskColors[]='#ffc107';
            break;

        case 'high':
            $riskColors[]='#dc3545';
            break;

        case 'critical':
            $riskColors[]='#212529';
            break;

        default:
            $riskColors[]='#6c757d';
    }

}

?>

<script>

document.addEventListener("DOMContentLoaded",function(){

<?php if(count($g)): ?>

new Chart(document.getElementById("gdpC"),{

    type:'bar',

    data:{

        labels:<?php echo json_encode(array_column($g, 'year'), 512) ?>,

        datasets:[{

            data:<?php echo json_encode(array_column($g, 'value'), 512) ?>,

            backgroundColor:'rgba(25,135,84,.75)',

            borderRadius:4

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}}

    }

});

<?php else: ?>

document.getElementById('gdpC').parentElement.innerHTML='<div class="text-center text-muted py-5">Data tidak tersedia</div>';

<?php endif; ?>



<?php if(count($inf)): ?>

new Chart(document.getElementById("inflC"),{

    type:'line',

    data:{

        labels:<?php echo json_encode(array_column($inf, 'year'), 512) ?>,

        datasets:[{

            data:<?php echo json_encode(array_column($inf, 'value'), 512) ?>,

            borderColor:'#dc3545',

            backgroundColor:'rgba(220,53,69,.15)',

            fill:true,

            tension:.4

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}}

    }

});

<?php else: ?>

document.getElementById('inflC').parentElement.innerHTML='<div class="text-center text-muted py-5">Data tidak tersedia</div>';

<?php endif; ?>



<?php if(isset($currencyTrend['rates']) && count($currencyTrend['rates'])): ?>

new Chart(document.getElementById("currC"),{

    type:'line',

    data:{

        labels:<?php echo json_encode($currencyTrend['labels'] ?? [], 15, 512) ?>,

        datasets:[{

            data:<?php echo json_encode($currencyTrend['rates'] ?? [], 15, 512) ?>,

            borderColor:'#ffc107',

            backgroundColor:'rgba(255,193,7,.15)',

            fill:true,

            tension:.4

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}}

    }

});

<?php else: ?>

document.getElementById('currC').parentElement.innerHTML='<div class="text-center text-muted py-5">Data kurs belum tersedia</div>';

<?php endif; ?>



<?php if(!empty($rt['labels'])): ?>

new Chart(document.getElementById("riskC"),{

    type:'line',

    data:{

        labels:<?php echo json_encode($rt['labels'], 15, 512) ?>,

        datasets:[{

            data:<?php echo json_encode($rt['data'], 15, 512) ?>,

            borderColor:'#0d6efd',

            backgroundColor:'rgba(13,110,253,.15)',

            fill:true,

            tension:.4,

            pointRadius:5,

            pointBackgroundColor:<?php echo json_encode($riskColors, 15, 512) ?>

        }]

    },

    options:{

        responsive:true,

        plugins:{legend:{display:false}},

        scales:{

            y:{

                min:0,

                max:100

            }

        }

    }

});

<?php else: ?>

document.getElementById('riskC').parentElement.innerHTML='<div class="text-center text-muted py-5">Belum ada histori risk score</div>';

<?php endif; ?>

});

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\Global Supply\supply-chain-platform\resources\views/visualization/show.blade.php ENDPATH**/ ?>