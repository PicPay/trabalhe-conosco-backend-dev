package br.com.picpay.rest;

import static org.springframework.hateoas.mvc.ControllerLinkBuilder.linkTo;
import static org.springframework.hateoas.mvc.ControllerLinkBuilder.methodOn;

import java.util.ArrayList;
import java.util.Collection;
import java.util.stream.Collectors;

import org.springframework.hateoas.Link;
import org.springframework.hateoas.PagedResources;
import org.springframework.hateoas.PagedResources.PageMetadata;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import br.com.picpay.trabalheconosco.api.User;
import br.com.picpay.trabalheconosco.api.UserIndex;
import br.com.picpay.trabalheconosco.api.UserQueryResult;

@RestController
public class UsersController {

	private final UserIndex userIndex;

	public UsersController(UserIndex userIndex) {
		this.userIndex = userIndex;
	}

	@GetMapping(path="/api/users", produces=MediaType.APPLICATION_JSON_VALUE)
	public PagedResources<User> search(
			@RequestParam(name = "key_word", required = true) String keyWord, 
			@RequestParam(name = "page", defaultValue = "0") int page) throws Exception {
		
		UserQueryResult result = this.userIndex.query(keyWord, page, 15);
		
		return new PagedResources<>(
				result.users().map(u -> new User.Fixed(u.id(), u.name(), u.username())).collect(Collectors.toList()), 
				new PagedResources.PageMetadata(15, page, result.total()), 
				links(keyWord, new PagedResources.PageMetadata(15, page, result.total())));
		
	}

	private Link[] links(String keyWord, PageMetadata metadata) throws Exception {
		Collection<Link> links = new ArrayList<>();
		links.add(linkTo(methodOn(UsersController.class).search(keyWord, (int)metadata.getNumber())).withSelfRel());
		links.add(linkTo(methodOn(UsersController.class).search(keyWord, 0)).withRel(Link.REL_FIRST));
		links.add(linkTo(methodOn(UsersController.class).search(keyWord, (int) (metadata.getTotalPages() -1))).withRel(Link.REL_LAST));
		
		if(metadata.getNumber() > 0) {
			links.add(linkTo(methodOn(UsersController.class).search(keyWord, (int) metadata.getNumber() -1)).withRel(Link.REL_PREVIOUS));
		}
		
		if(metadata.getNumber() < metadata.getTotalElements() -1) {
			links.add(linkTo(methodOn(UsersController.class).search(keyWord, (int) metadata.getNumber() + 1)).withRel(Link.REL_NEXT));
		}
		
		
		
		
		return links.toArray(new Link[] {});
	}
}

