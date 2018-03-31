<div class="grid_95P margin_left_3">
	<h2>Usuários</h2>
</div>

<div class="grid_95P margin_left_3">
	
			
	<div class="tabbed-area" ng-app="usuarios" ng-controller="UsuariosController">
		
		
		<div class="box-wrap">
		
			<input type="text" placeholder="Pesquisar usuário" name="busca" ng-model="busca">
			<input type="button" name="buscar" value="Ok" ng-click="buscar()">
			</br></br>
			
			<img src="/app/webroot/img/loading.gif" width="100px;" align="center" ng-if="loading">
			
			<table cellpadding="0" cellspacing="0" class="datagrid" ng-if="users.length > 0">
			  <caption></caption>
				<thead>
					<tr>
						<th align=left >Nome</th>
						<th align=left >Login</th>
						<th align=left >Chave</th>
						<th align=left >Prioridade</th>
					</tr>
				</thead>
				<tbody>
				
				
			<!--		<tr ng-repeat="usuario in users" > -->
					<tr dir-paginate="usuario in users|itemsPerPage:15" >
						<td style="padding-right: 30px !important;">
							{{usuario.nome}}
						</td>
						
						<td style="padding-right: 30px !important;">
							{{usuario.login}}
						</td>
						<td style="padding-right: 30px !important;">
							{{usuario.chave}}
						</td>
						<td style="padding-right: 30px !important;">
							{{usuario.p}}
						</td>
					</tr>
				</tbody>
			</table>			
		</div>
		
		
		
		<!-- Pagination  -->
		<div class="grid_95P margin_left_3 margin_top_1 margin_bottom_2 pagination" ng-if="users.length > 0">
			<dir-pagination-controls max-size="5" boundary-links="true"></dir-pagination-controls>
		</div>
		<!-- /Paginations --> 
		
	</div>
</div>
<!-- /Datagrid -->
