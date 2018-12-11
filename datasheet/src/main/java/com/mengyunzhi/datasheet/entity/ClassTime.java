package com.mengyunzhi.datasheet.entity;

import javax.persistence.*;

@Entity
public class ClassTime {

    @Id                                                       //Id为主键自增
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                                       // 上课时间Id(主键)

    private Integer week;                                     // 周

    private Integer day;                                      // 天

    private Integer period;                                   // 节

    @ManyToOne                                                // 引入课程
    private Course course;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getWeek() {
        return week;
    }

    public void setWeek(Integer week) {
        this.week = week;
    }

    public Integer getDay() {
        return day;
    }

    public void setDay(Integer day) {
        this.day = day;
    }

    public Integer getPeriod() {
        return period;
    }

    public void setPeriod(Integer period) {
        this.period = period;
    }

    public Course getCourse() {
        return course;
    }

    public void setCourse(Course course) {
        this.course = course;
    }
}
