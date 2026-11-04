<tr>
    <td
        @if ($columns !== null)
            colspan="{{ (!$noCheckbox) ? $columns : ($columns + 1) }}"
        @endif
    >
        {{ $slot }}
    </td>
</tr>
