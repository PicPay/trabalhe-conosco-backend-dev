package com.kklein.dao;

import java.util.List;

import javax.persistence.EntityManager;

import com.kklein.bean.Usuario;

public class UsuarioDao extends AbstractJpaDao<Usuario> {

	public UsuarioDao(EntityManager entityManager) {
		super(entityManager);
	}

	public static final int QUANTIDADE_REGISTROS = 0;
	public static final int USU_NM_USUARIO = 1;
	public static final int USU_DS_LOGIN = 2;
	public static final int USU_DS_CODIGO = 3;
	public static final int LISTA1 = 4;
	public static final int LISTA2 = 5;


	public List<Object[]> consultaListaUsuario(final String palavra, final int pagina) throws Exception {
		StringBuilder sql = new StringBuilder();
		sql.append("SELECT ")
		.append("        (SELECT ")
		.append("            Count(1)          ")
		.append("        FROM ")
		.append("            usuario b          ")
		.append("        WHERE 1 = 1 ")
		.append("            and (b.usu_nm_usuario LIKE '%"+palavra+"%'         ")
		.append("            or b.usu_ds_login LIKE '%"+palavra+"%')  ")
		.append("            ) AS linhas, ")
		.append("        a.usu_nm_usuario, ")
		.append("        a.usu_ds_login, ")
		.append("        a.usu_ds_codigo ")
		.append("    FROM ")
		.append("        usuario a         ")
		.append("    WHERE  1 = 1 ")
		.append("        and (a.usu_nm_usuario LIKE '%"+palavra+"%'  ")
		.append("        or a.usu_ds_login LIKE '%"+palavra+"%') ")
		.append("         ")
		.append("    GROUP  BY ")
		.append("        a.usu_cd_usuario  ")
		.append("    ORDER  BY ")
		.append("		a.usu_fl_lista_prioridade, ")
		.append("        a.usu_cd_usuario  ")
		.append("  limit " + 15 + " offset " + 15*(pagina-1));
		
		return getListSqlNativo(sql.toString());
	}

}