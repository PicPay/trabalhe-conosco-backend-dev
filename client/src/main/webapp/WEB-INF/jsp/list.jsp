<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Bootstrap CSS -->
<link href="/css/bootstrap.min.css" rel="stylesheet" media="screen">
</head>
<body>

	<div class="container">


		<c:choose>
			<c:when test="${ 1 == 1 }">

				<fieldset>

					<legend>Pesquisar</legend>

					<form class="navbar-form pull-left" action="/users/1/1" method="get">
						<input type="text" name="query" class="span2"
							value="${not empty query ? query : null}">
						<button type="submit" class="btn">Buscar</button>
					</form>

				</fieldset>


				<fieldset>
					<legend>Usuários</legend>



					<table class="table table-striped">

						<thead>
							<tr>
								<th>ID</th>
								<th>Nome</th>
								<th>Username</th>
							</tr>
						</thead>
						<c:if test="${not empty users}">

							<c:forEach var="user" items="${users}">
								<tr>
									<td>${user.id}</td>
									<td>${user.nome}</td>
									<td>${user.apelido}</td>
								</tr>

							</c:forEach>


							<tfoot>
								<tr>
									<td colspan="3">

										<div class="pagination pagination-mini">

											<ul>
												<c:forEach var="i" begin="1" end="${total}">
													<c:choose>
														<c:when test="${page == i }">
															<li class="active"><a
																href="/users/${i}/${total}?query=${query}">${i}</a></li>
														</c:when>
														<c:otherwise>
															<li class="disabled"><a
																href="/users/${i}/${total}?query=${query}">${i}</a></li>
														</c:otherwise>
													</c:choose>


												</c:forEach>
											</ul>
										</div>

									</td>
								</tr>
							</tfoot>

						</c:if>

						<c:if test="${ empty users}">

							<tr>
								<td colspan="3">Registro não encontrado</td>
							</tr>

						</c:if>


					</table>
				</fieldset>
			</c:when>

			<c:otherwise>
				<h1>Banco de dados está sendo carregado...</h1>
			</c:otherwise>

		</c:choose>

	</div>
</body>
</html>