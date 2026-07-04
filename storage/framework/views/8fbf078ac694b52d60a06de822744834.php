<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('title', 'Página no encontrada 🤔'); ?>
<?php $__env->startSection('message', 'Tú, yo, y el pollito estamos igual de perdidos. No tenemos ni idea de cómo llegaste aquí, pero esta página no existe. ¡Regresa a casa por favor!'); ?>

<?php $__env->startSection('image-url', asset('images/error_404_pollito.png')); ?>

<?php echo $__env->make('errors.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/errors/404.blade.php ENDPATH**/ ?>