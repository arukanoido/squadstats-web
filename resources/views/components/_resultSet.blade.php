<table>
    <thead>
        <tr>
            @foreach ($resultSet['ResultSetMetadata']['ColumnInfo'] as $columnInfo)
            <td>
                {{ $columnInfo['Name'] }}
            </td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($resultSet['Rows'] as $key => $row)
        @if (!$loop->first)
        <tr>
            @foreach ($row['Data'] as $column)
            <td>
                <?php
                $colName = $resultSet['ResultSetMetadata']['ColumnInfo'][$loop->index]['Name'];
                $view = (View::exists('components.columns.' . $colName))
                    ? 'components.columns.' . $colName
                    : 'components.columns.default';
                ?>
                @if (isset($column['VarCharValue']))
                    @component ($view, ['value' => $column['VarCharValue']])
                    @endcomponent
                @endif
            </td>
            @endforeach
        </tr>
        @endif
        @endforeach
    </tbody>
</table>