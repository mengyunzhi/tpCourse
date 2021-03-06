package com.mengyunzhi.datasheet.entity;


import javax.persistence.*;

@Entity
public class Course {

    @Id                                                      // Id为主键自增
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                                      // 课程Id（主键）

    private String name;                                     // 名称

    @ManyToOne                                               // 引入学期
    private Term term;

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

    public Term getTerm() {
        return term;
    }

    public void setTerm(Term term) {
        this.term = term;
    }
}
