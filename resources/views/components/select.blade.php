<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
    <select {{ $attributes->merge(['class' => 'form-select']) }}>
        {{ $slot }}
    </select>
</div>
