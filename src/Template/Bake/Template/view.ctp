<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'] + $associations['HasOne'];
$associationFields = collection($fields)
    ->map(function($field) use ($immediateAssociations) {
        foreach ($immediateAssociations as $alias => $details) {
            if ($field === $details['foreignKey']) {
                return [$field => $details];
            }
        }
    })
    ->filter()
    ->reduce(function($fields, $value) {
        return $fields + $value;
    }, []);

$groupedFields = collection($fields)
    ->filter(function($field) use ($schema) {
        return $schema->columnType($field) !== 'binary';
    })
    ->groupBy(function($field) use ($schema, $associationFields) {
        $type = $schema->columnType($field);
        if (isset($associationFields[$field])) {
            return 'string';
        }
        if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
            return 'number';
        }
        if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
            return 'date';
        }
        return in_array($type, ['text', 'boolean']) ? $type : 'string';
    })
    ->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
%>
<div class="subnav">
    <ul class="subnavitems list-inline">
        <li><?= $this->Html->link(__('Edit <%= $singularHumanName %>'),
            ['action' => 'edit', <%= $pk %>],
            ['class'=>'btn btn-sm btn-primary']) ?> </li>
        <li><?= $this->Form->postLink(__('Delete <%= $singularHumanName %>'),
            ['action' => 'delete', <%= $pk %>],
            ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>),'class'=>'btn btn-sm btn-primary']) ?> </li>
        <li><?= $this->Html->link(__('List <%= $pluralHumanName %>'),
            ['action' => 'index'],
            ['class'=>'btn btn-sm btn-primary']) ?> </li>
        <li><?= $this->Html->link(__('New <%= $singularHumanName %>'),
            ['action' => 'add'],
            ['class'=>'btn btn-sm btn-primary']) ?> </li>
<%
    $done = [];
    foreach ($associations as $type => $data) {
        foreach ($data as $alias => $details) {
            if ($details['controller'] !== $this->name && !in_array($details['controller'], $done)) {
%>
        <li><?= $this->Html->link(__('List <%= $this->_pluralHumanName($alias) %>'),
            ['controller' => '<%= $details['controller'] %>', 'action' => 'index'],
            ['class'=>'btn btn-sm btn-primary']) ?> </li>
        <li><?= $this->Html->link(__('New <%= Inflector::humanize(Inflector::singularize(Inflector::underscore($alias))) %>'),
            ['controller' => '<%= $details['controller'] %>', 'action' => 'add'],
            ['class'=>'btn btn-sm btn-primary']) ?> </li>
<%
                $done[] = $details['controller'];
            }
        }
    }
%>
    </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><?= __('<%= $singularHumanName %>') ?></div>
  <div class="<%= $pluralVar %> view content">
    <h3><?= h($<%= $singularVar %>-><%= $displayField %>) ?></h3>
    <table class="table vertical-table">
<% if ($groupedFields['string']) : %>
<% foreach ($groupedFields['string'] as $field) : %>
<% if (isset($associationFields[$field])) :
            $details = $associationFields[$field];
%>
        <tr>
            <th><?= __('<%= Inflector::humanize($details['property']) %>') ?></th>
            <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ? $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>-><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>', 'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>-><%= $details['primaryKey'][0] %>]) : '' ?></td>
        </tr>
<% else : %>
        <tr>
            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
        </tr>
<% endif; %>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['number']) : %>
<% foreach ($groupedFields['number'] as $field) : %>
        <tr>
            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['date']) : %>
<% foreach ($groupedFields['date'] as $field) : %>
        <tr>
            <th><%= "<%= __('" . Inflector::humanize($field) . "') %>" %></th>
            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></tr>
        </tr>
<% endforeach; %>
<% endif; %>
<% if ($groupedFields['boolean']) : %>
<% foreach ($groupedFields['boolean'] as $field) : %>
        <tr>
            <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
            <td><?= $<%= $singularVar %>-><%= $field %> ? __('Yes') : __('No'); ?></td>
         </tr>
<% endforeach; %>
<% endif; %>
    </table>
<% if ($groupedFields['text']) : %>
<% foreach ($groupedFields['text'] as $field) : %>
    <div class="rowtext">
        <h4><?= __('<%= Inflector::humanize($field) %>') ?></h4>
        <?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)); ?>
    </div>
<% endforeach; %>
<% endif; %>
  </div>
</div>
<%
$relations = $associations['HasMany'] + $associations['BelongsToMany'];
foreach ($relations as $alias => $details):
    $otherSingularVar = Inflector::variable($alias);
    $otherPluralHumanName = Inflector::humanize(Inflector::underscore($details['controller']));
    %>
    <div class="related row">
        <h4><?= __('Related <%= $otherPluralHumanName %>') ?></h4>
        <?php if (!empty($<%= $singularVar %>-><%= $details['property'] %>)): ?>
        <table class="table">
            <tr>
<% foreach ($details['fields'] as $field): %>
                <th><?= __('<%= Inflector::humanize($field) %>') ?></th>
<% endforeach; %>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($<%= $singularVar %>-><%= $details['property'] %> as $<%= $otherSingularVar %>): ?>
            <tr>
            <%- foreach ($details['fields'] as $field): %>
                <td><?= h($<%= $otherSingularVar %>-><%= $field %>) ?></td>
            <%- endforeach; %>
            <%- $otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}"; %>
                <td class="actions">
                    <?= $this->Html->link('', ['controller' => '<%= $details['controller'] %>', 'action' => 'view', <%= $otherPk %>], ['title' => __('View'), 'class' => 'btn btn-xs glyphicon glyphicon-eye-open']) %>
                    <?= $this->Html->link('', ['controller' => '<%= $details['controller'] %>', 'action' => 'edit', <%= $otherPk %>], ['title' => __('Edit'), 'class' => 'btn btn-xs glyphicon glyphicon-pencil']) %>
                    <?= $this->Form->postLink('', ['controller' => '<%= $details['controller'] %>', 'action' => 'delete', <%= $otherPk %>], ['confirm' => __('Are you sure you want to delete # {0}?', <%= $otherPk %>), 'title' => __('Delete'), 'class' => 'btn btn-xs glyphicon glyphicon-trash']) %>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div>
<% endforeach; %>

