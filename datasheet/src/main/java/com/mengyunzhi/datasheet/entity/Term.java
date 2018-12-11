package com.mengyunzhi.datasheet.entity;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import java.sql.Date;

@Entity
public class Term {

    @Id                                                      // Id为主键自增
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                                      // 主键

    private String name;                                     // 名称

    private Date startTime;                                  // 起始时间

    private Date endTime;                                    // 结束时间

    private boolean state;                                   // 学期状态

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

    public Date getStartTime() {
        return startTime;
    }

    public void setStartTime(Date startTime) {
        this.startTime = startTime;
    }

    public Date getEndTime() {
        return endTime;
    }

    public void setEndTime(Date endTime) {
        this.endTime = endTime;
    }

    public boolean isState() {
        return state;
    }

    public void setState(boolean state) {
        this.state = state;
    }
}
