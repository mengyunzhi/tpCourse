package com.mengyunzhi.datasheet.entity;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

@Entity
public class Term {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                                      // 主键

    private String name;                                     // 名称

    public Term() {
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
}
