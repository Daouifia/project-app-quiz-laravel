

<?php $__env->startSection('title', 'Quiz - Groupe ' . $groupe); ?>

<?php $__env->startSection('content'); ?>
<div class="navbar">
    <div class="navbar-brand">Quiz App - <?php echo e(ucfirst(Auth::user()->role)); ?></div>
    <div class="navbar-menu">
        <?php if(Auth::user()->role === 'professor'): ?>
            <a href="<?php echo e(route('professor.groupes')); ?>" class="navbar-link">← Retour aux Groupes</a>
        <?php elseif(Auth::user()->role === 'student'): ?>
            <a href="<?php echo e(route('student.groupes')); ?>" class="navbar-link">← Retour aux Groupes</a>
        <?php else: ?>
            <a href="<?php echo e(route('admin.groupes')); ?>" class="navbar-link">← Retour aux Groupes</a>
        <?php endif; ?>
        <span style="color: #6b7280;">👤 <?php echo e(Auth::user()->name); ?></span>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary">🚪 Déconnexion</button>
        </form>
    </div>
</div>

<div class="container">
    <h1>👨‍👩‍👧‍👦 Groupe: <?php echo e($groupe); ?></h1>

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Quiz dans ce groupe</p>
            <h3><?php echo e($quizzes->count()); ?></h3>
        </div>
        <div class="stat-card">
            <p>Modules</p>
            <h3><?php echo e($quizzes->pluck('module')->unique()->count()); ?></h3>
        </div>
    </div>

    <div class="card" style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px; color: #667eea;">Modules disponibles</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <?php $__currentLoopData = $quizzes->pluck('module')->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span style="padding: 8px 16px; background: #667eea; color: white; border-radius: 20px; font-size: 14px; font-weight: 600;">
                📚 <?php echo e($module); ?>

            </span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 20px; color: #667eea;">Quiz disponibles</h3>
        
        <?php if($quizzes->count() === 0): ?>
        <div class="card">
            <p style="text-align: center; color: #6b7280;">
                Aucun quiz disponible pour ce groupe.
            </p>
        </div>
        <?php else: ?>
        <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card" style="margin-bottom: 15px;">
            <h3 style="color: #667eea; margin-bottom: 10px;"><?php echo e($quiz->title); ?></h3>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Module:</strong> <?php echo e($quiz->module); ?>

            </p>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Durée:</strong> <?php echo e($quiz->duration); ?> minutes
            </p>
            <p style="color: #6b7280;">
                <strong>Questions:</strong> <?php echo e($quiz->questions_count); ?> | 
                <strong>Tentatives:</strong> <?php echo e($quiz->results_count); ?>

            </p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aouif\Desktop\finallaravel\backend\resources\views/dashboard/groupe-quizzes.blade.php ENDPATH**/ ?>