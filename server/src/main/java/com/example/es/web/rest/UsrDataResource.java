package com.example.es.web.rest;

import java.util.List;

import com.example.es.domain.UsrData;
import com.example.es.repository.es.UsrDataRepository;
import com.example.es.web.rest.util.PaginationUtil;

import org.springframework.http.HttpHeaders;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.data.domain.Pageable;
import org.springframework.data.web.PageableDefault;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;

@RestController
@RequestMapping("/api")
public class UsrDataResource{

    @Autowired
    private UsrDataRepository usrDataRepository;

    /**
     * GET  /usr-data : get all the usrData.
     *
     * @param pageable the pagination information
     * @return the ResponseEntity with status 200 (OK) and the list of usrData in body
     */
    @GetMapping("/usr-data")
    public ResponseEntity<List<UsrData>> getAllUsrData(@RequestParam(value = "query", required=false) String query, @PageableDefault(size = 15) Pageable pageable) {  
        
        if(query==null){
            query="";
        }       
       

        Page<UsrData> page = usrDataRepository.findByNameLikeOrUsernameLikeOrderByVip1DescVip2Desc(query,query,pageable);
        HttpHeaders headers = PaginationUtil.generatePaginationHttpHeaders(page, "/api/usr-data");
        return ResponseEntity.ok().headers(headers).body(page.getContent());
    }

}