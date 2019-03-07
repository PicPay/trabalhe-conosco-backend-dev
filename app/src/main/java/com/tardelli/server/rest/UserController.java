package com.tardelli.server.rest;

import com.tardelli.server.dao.UserElasticRepository;
import com.tardelli.server.model.User;
import io.swagger.annotations.Api;
import io.swagger.annotations.ApiOperation;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Sort;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.Objects;
import java.util.logging.Level;
import java.util.logging.Logger;

@RestController
@RequestMapping("/api/user")
@Api(value = "User", description = "Operations pertaining to users")

public class UserController {
    private final Logger logger = Logger.getLogger(this.getClass().getName());

    @Autowired
    private UserElasticRepository repository;

    @ApiOperation(value = "find users by name or username",
            position = 1,
            notes = " <span class=\"detail\">" +
                    " <span class=\"title\">Esta API efetua uma busca por name ou username, caso o valor chave enviado na requisição esteja em alguma parte do texto é retornada uma lista paginada. </span>" +
                    " </span><br><br>" +
                    " <table class=\"badRequestlist\">" +
                    " <tr><td>key </td><td> Texto chave que será buscado </td></tr>" +
                    " <tr><td>rows </td><td> Quantidade de linhas retornadas por pagina, valor padrão 10 </td></tr>" +
                    " <tr><td>page </td><td> Utilizado para apontar qual pagina a ser retornada, valor padrão 0 </td></tr>" +
                    " </table>",
            response = Page.class)
    @RequestMapping(value = "/", method = RequestMethod.GET, produces = MediaType.APPLICATION_JSON_VALUE)
    public ResponseEntity<Page> findUsersByUsername(@RequestParam String key, @RequestParam(required = false) Integer page, @RequestParam(required = false) Integer rows) {

        Page<User> users = repository.findByUserNameOrNameContaining(key, key, PageRequest.of(page == null ? 0 : page, rows == null ? 10 : rows, Sort.by("relevancy")));

        return new ResponseEntity<>(users, HttpStatus.OK);
    }

    @ApiOperation(value = "update user", response = User.class)
    @RequestMapping(value = "/", method = RequestMethod.PUT, consumes = MediaType.APPLICATION_JSON_VALUE, produces = MediaType.APPLICATION_JSON_VALUE)
    public ResponseEntity update(@RequestBody User user) {

        if (Objects.isNull(user)) {
            logger.log(Level.INFO, "object is null in put ");
            return new ResponseEntity<>("object is null in put ", HttpStatus.OK);
        }

        if (Objects.isNull(user.getId())) {
            logger.log(Level.INFO, "object ID is null in put ");
            return new ResponseEntity<>("object ID is null in put ", HttpStatus.OK);
        }

        User save = repository.save(user);

        return new ResponseEntity<>(save, HttpStatus.CREATED);
    }

}
