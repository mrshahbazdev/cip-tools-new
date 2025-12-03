<thead class="bg-gray-50">
    <tr>
        @include('livewire.partials.pipeline-table-header', ['field' => 'name', 'label' => 'IDEA / PROBLEM'])
        <th class="bg-yellow-100 px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">Schmerz</th>
        <th class="bg-red-100 px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">LÖSUNG</th>
        <th class="bg-red-100 px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">Kosten</th>
        <th class="bg-red-100 px-6 py-3 text-xs font-medium text-gray-700 uppercase tracking-wider">Dauer</th>
        @include('livewire.partials.pipeline-table-header', ['field' => 'prio_1', 'label' => 'PRIO 1'])
        @include('livewire.partials.pipeline-table-header', ['field' => 'prio_2', 'label' => 'PRIO 2'])
        @include('livewire.partials.pipeline-table-header', ['field' => 'priority', 'label' => 'Umsetzung'])
        <th class="px-6 py-3"></th>
    </tr>
</thead>