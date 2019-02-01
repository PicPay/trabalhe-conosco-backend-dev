package br.com.guiabolso.recommendation

import org.springframework.web.bind.annotation.RequestMapping
import org.springframework.stereotype.Controller

@Controller
class HomeController {

    @RequestMapping()
    fun home() : String {
        return "index.html"
    }
}